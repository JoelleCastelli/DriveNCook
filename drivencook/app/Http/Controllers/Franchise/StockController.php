<?php


namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
use App\Models\Dish;
use App\Models\FranchiseeStock;
use App\Models\FranchiseObligation;
use App\Models\Invoice;
use App\Models\PurchasedDish;
use App\Models\PurchaseOrder;
use App\Models\Warehouse;
use App\Models\WarehousStock;
use App\Traits\EnumValue;
use App\Traits\UserTools;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class StockController extends Controller
{
    use UserTools;
    use EnumValue;

    public function __construct()
    {
        $this->middleware(AuthFranchise::class);
    }

    public function stock_dashboard()
    {
        $user_id = $this->get_connected_user()['id'];
        $purchase_order = PurchaseOrder::where('user_id', $user_id)
            ->with('purchased_dishes')
            ->with('warehouse')
            ->get()->toArray();
        $stock = FranchiseeStock::with('dish')
            ->where('user_id', $user_id)
            ->get()->toArray();
        $current_obligation = $this->get_current_obligation();
        $current_obligation['date_updated'] = DateTime::createFromFormat("Y-m-d", $current_obligation['date_updated'])->format('d/m/Y');
        return view('franchise.stock.stock_dashboard')
            ->with('stock', $stock)
            ->with('purchase_order', $purchase_order)
            ->with('current_obligation', $current_obligation);
    }

    public function stock_order()
    {
        $warehouses_list = [];
        $warehouses = Warehouse::with('city')
            ->with('available_dishes')
            ->get()->toArray();

        foreach ($warehouses as $warehouse) {
            if (!empty($warehouse['available_dishes'])) {
                $warehouses_list[] = $warehouse;
            }
        }

        return view('franchise.stock.stock_order_form')
            ->with("warehouse_list", $warehouses_list);
    }

    public function stock_order_warehouse($warehouse_id)
    {
        $warehouse = Warehouse::whereKey($warehouse_id)
            ->with('city')
            ->with('stock')
            ->first();
        if ($warehouse == null) {
            abort(404);
        }
        $warehouse = $warehouse->toArray();
//        var_dump($warehouse);die;
        return view('franchise.stock.stock_order_form')
            ->with('warehouse', $warehouse);
        //json
    }

    public function stock_order_submit()
    {
        $order = [];
        $order['warehouse_id'] = request('warehouse_id');
        $order['total'] = 0;
        $order['dishes'] = [];

        foreach (request()->except(['_token', 'warehouse_id']) as $dish_id => $quantity) {
            if ($quantity > 0) {
                $dish_id = explode('_', $dish_id)[1];
                $warehouse_stock = $this->get_warehouse_product_stock($dish_id, $order['warehouse_id']);
                if ($warehouse_stock == null || $warehouse_stock['quantity'] < $quantity) {
                    flash("Erreur, un des produits commandés n'est pas disponible dans cet entrepôt ou le stock est insuffisant")->error();
                    return back();
                }

                $order['dishes'][] = array(
                    "id" => $dish_id,
                    "quantity" => $quantity,
                    "price" => $warehouse_stock['warehouse_price'],
                    "dish" => Dish::find($dish_id)->toArray()
                );
                $order['total'] += $quantity * $warehouse_stock['warehouse_price'];
            }
        }
        if (count($order['dishes']) == 0) {
            flash("Aucun plats choisis")->error();
            return back();
        }
//        var_dump($order);die;
        request()->session()->put('order', $order);

        return view('franchise.stock.stock_order_payment')
            ->with('order', $order);
    }

    public function charge(Request $request, $order_total_cents)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => $order_total_cents,
                'currency' => 'eur'
            ));

            return $this->stock_order_validate($order_total_cents / 100);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function stock_order_validate($order_total)
    {
        $order = request()->session()->pull('order', null);
        if ($order == null) {
            flash("Erreur, la commande a expiré, veuillez réessayer")->warning();
            return redirect(route('franchise.stock_order'));
        }

        $order_id = PurchaseOrder::insertGetId([
            'user_id' => $this->get_connected_user()['id'],
            'warehouse_id' => $order['warehouse_id'],
            'date' => Carbon::now()->toDateString()
        ]);
        foreach ($order['dishes'] as $order_dish) {
            PurchasedDish::insert([
                'purchase_order_id' => $order_id,
                'dish_id' => $order_dish['id'],
                'quantity' => $order_dish['quantity'],
                'unit_price' => $order_dish['price']
            ]);

            $previous_warehouse_stock = WarehousStock::where([
                ['warehouse_id', $order['warehouse_id']],
                ['dish_id', $order_dish['id']]
            ])->first()->quantity;
            WarehousStock::where([
                ['warehouse_id', $order['warehouse_id']],
                ['dish_id', $order_dish['id']]
            ])->update([
                'quantity' => $previous_warehouse_stock - $order_dish['quantity']
            ]);
        }

        // invoice creation
        $invoice = ['amount' => $order_total,
            'date_emitted' => date("Y-m-d"),
            'monthly_fee' => 0,
            'initial_fee' => 0,
            'user_id' => $this->get_connected_user()['id'],
            'purchase_order_id' => $order_id];
        $invoice = Invoice::create($invoice)->toArray();
        $reference = $this->create_invoice_reference('RS', $this->get_connected_user()['id'], $invoice['id']);
        $this->save_franchisee_invoice_pdf($invoice['id'], $reference);

        flash('Commande créée !
                <a href="' . route('franchise.stream_invoice_pdf', ['id' => $invoice['id']]) . '">Consultez la facture au format PDF</a>
                ou retrouvez-la dans la rubrique <a href="' . route('franchise.invoices_list') . '">Factures</a>.')
            ->success();

        return redirect(route('franchise.stock_dashboard'));
    }

    public function get_warehouse_product_stock($dish_id, $warehouse_id)
    {
        $warehouse_stock = WarehousStock::where([
            ['dish_id', $dish_id],
            ['warehouse_id', $warehouse_id]
        ])->first();
        if ($warehouse_stock != null) {
            $warehouse_stock = $warehouse_stock->toArray();
        }
        return $warehouse_stock;
    }

    public function stock_order_cancel($order_id)
    {
        $order = PurchaseOrder::whereKey($order_id)->first();
        if ($order == null) {
            return 'order not found';
        }
        $order = $order->toArray();
        if ($order['status'] != 'created') {
            return 'can\'t cancel order anymore';
        }
        PurchasedDish::where('purchase_order_id')->delete();
        PurchaseOrder::whereKey($order_id)->delete();
        return $order_id;
    }

    public function stock_order_view($order_id)
    {
        $order = PurchaseOrder::with('purchased_dishes')
            ->with('warehouse')
            ->whereKey($order_id)
            ->first();
        if ($order == null) {
            abort(404);
        }
        $order = $order->toArray();
//        var_dump($order);die;
        return view('franchise.stock.stock_order_view')
            ->with('order', $order);
    }

    public function stock_update_submit()
    {
        request()->validate([
            'dish_id' => ['required', 'integer'],
            'unit_price' => ['required', 'numeric']
        ]);
        FranchiseeStock::where([
            ['user_id', $this->get_connected_user()['id']],
            ['dish_id', request('dish_id')]
        ])->update(['unit_price' => request('unit_price')]);

        return json_encode(array('response' => 'success'));
    }

    public function stock_update_menu_available()
    {
        request()->validate([
            'dish_id' => ['required', 'integer'],
            'available' => ['required', 'boolean'],
        ]);

        FranchiseeStock::where([
            ['user_id', $this->get_connected_user()['id']],
            ['dish_id', request('dish_id')]
        ])->update(['menu' => request('available') ? 1 : 0]);

        return json_encode(array('response' => 'success'));
    }
}