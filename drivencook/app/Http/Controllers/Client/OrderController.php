<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FranchiseeStock;
use App\Models\FidelityStep;
use App\Models\Invoice;
use App\Models\Sale;
use App\Models\SoldDish;
use App\Models\Truck;
use App\Models\User;
use App\Traits\EmailTools;
use App\Traits\LoyaltyTools;
use App\Traits\SaleTools;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Traits\UserTools;
use App\Traits\TruckTools;
use App\Traits\StockTools;
use Session;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Refund;
use Stripe\Stripe;

class OrderController extends Controller
{
    use UserTools;
    use TruckTools;
    use StockTools;
    use LoyaltyTools;
    use EmailTools;
    use SaleTools;

    public function truck_location_list()
    {
        $trucks = Truck::where([
            ['functional', true],
            ['user_id', "!=", null]
        ])->with('user')
            ->with('location')
            ->get();

        if (!empty($trucks)) {
            $trucks = $trucks->toArray();
        }

        return view('client.order.truck_location_list')
            ->with('trucks', $trucks);
    }

    public function client_order($truck_id)
    {
        $truck = Truck::whereKey($truck_id)
                        ->with('user')
                        ->with('location')
                        ->first();

        if (!empty($truck)) {
            $truck = $truck->toArray();
        }

        $stocks = FranchiseeStock::where([
                                    ['user_id', $truck['user']['id']],
                                    ['menu', true]
                                    ])->with('dish')
                                      ->with('user')
                                      ->get();

        $fidelity_step = '';

        $stock_by_category = [];
        if (!empty($stocks) && !empty($stocks[0])) {
            $stocks = $stocks->toArray();
            $dish_categories = $this->get_enum_column_values('dish', 'category');
            foreach($dish_categories as $dish_category) {
                foreach($stocks as $stock) {
                    if ($stock['dish']['category'] == $dish_category) {
                        $stock_by_category[$dish_category][] = $stock;
                    }
                }
            }

            $fidelity_step = FidelityStep::orderBy('reduction')
                ->get();
            if (!empty($fidelity_step)) {
                $fidelity_step = $fidelity_step->toArray();
            }
        }

        $client = User::whereKey($this->get_connected_user())
            ->first();

        if (!empty($client)) {
            $client = $client->toArray();
        }

        return view('client.order.client_order')
            ->with('stocks', $stocks)
            ->with('stock_by_category', $stock_by_category)
            ->with('promotions', $fidelity_step)
            ->with('client', $client)
            ->with('truck', $truck);
    }

    public function check_order_array($array): bool
    {
        if ($array['truck_id']) {
            $truck = Truck::whereKey($array['truck_id'])
                ->with('user')
                ->first();

            if (!empty($truck)) {
                $truck = $truck->toArray();
            }

            unset($array['truck_id']);
            unset($array['discount_id']);
            foreach ($array['order'] as $dishId => $quantity) {
                $result = FranchiseeStock::where([
                    ['user_id', $truck['user']['id']],
                    ['dish_id', $dishId],
                    ['menu', true]
                ])->get();

                if (!(count($result) > 0)) {
                    return false;
                } else if ($quantity > $result[0]['quantity']) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    public function client_order_submit(Request $request)
    {
        $parameters = $request->toArray();
        $order = $request->except(['truck_id', 'discount_id']);
        $errors_list = [];

        if (!empty($parameters['order'])
            && !empty($parameters['truck_id'])
            && !empty($order['order'])) {

            $parameters['order'] = get_object_vars(json_decode($parameters['order']));
            $order['order'] = get_object_vars(json_decode($order['order']));

            if ($this->check_order_array($parameters)) {
                $user_id = $this->get_truck_with_franchisee_by_truck_id($parameters['truck_id'])['user']['id'];

                $sum = 0;
                $i = 0;
                foreach ($order['order'] as $dishId => $quantity) {
                    $stock = $this->get_franchisee_stock($dishId, $user_id);

                    $sum += $stock['unit_price'] * $quantity;

                    $order['order']['dishes'][$i]['name'] = $stock['dish']['name'];
                    $order['order']['dishes'][$i]['quantity'] = $quantity;
                    $order['order']['dishes'][$i]['unit_price'] = $stock['unit_price'];

                    $i++;
                }
                if (!empty($parameters['discount_id'])) {
                    $fidelityStep = FidelityStep::whereKey($parameters['discount_id'])
                        ->first();

                    $order['order']['discount_amount'] = $fidelityStep->reduction;

                    $sum -= $fidelityStep->reduction;
                    $sum = round($sum, 2);
                    if ($sum < 1) {
                        $sum = 0;
                    }
                }

                $order['order']['total'] = $sum;

                $order['order']['truck_id'] = $parameters['truck_id'];
                $order['order']['discount_id'] = $parameters['discount_id'];
                request()->session()->put('order', $order['order']);

                $response_array = [
                    'status' => 'success',
                ];
            } else {
                $errors_list[] = trans('client/order.error_in_post_data');

                $response_array = [
                    'status' => 'error',
                    'errorList' => $errors_list
                ];
            }
        } else {
            $errors_list[] = trans('client/order.missing_post_data');

            $response_array = [
                'status' => 'error',
                'errorList' => $errors_list
            ];
        }

        echo json_encode($response_array);
    }

    public function client_order_charge()
    {
        $order = request()->session()->get('order', null);
        if ($order == null) {
            flash(trans('client/order.order_expired'))->warning();
            return redirect(route('truck_location_list'));
        }

        $discount = '';
        if (!empty($order['discount_id'])) {
            $discount = FidelityStep::whereKey($order['discount_id'])
                ->first();
        }

        return view('client.order.client_order_payment')
            ->with('order', $order)
            ->with('discount', $discount);
    }

    public function client_order_validate()
    {
        $clientId = $this->get_connected_user()['id'];
        $order = request()->session()->pull('order', null);
        if ($order == null) {
            flash(trans('client/order.order_expired'))->warning();
            return redirect(route('truck_location_list'));
        }

        unset($order['dishes']);
        unset($order['total']);
        $user_id = $this->get_truck_with_franchisee_by_truck_id($order['truck_id'])['user']['id'];

        $payment_method = Session::pull('payment_method');
        $payment_id = Session::pull('charge_id');
        if ($payment_method == 'cash') {
            $payment_method = 'Liquide';
        } else {
            $payment_method = 'Carte bancaire';
        }

        $sale = [
            'online_order' => true,
            'date' => Carbon::now()->toDateString(),
            'user_franchised' => $user_id,
            'user_client' => $clientId,
            'status' => 'pending',
            'payment_method' => $payment_method,
            'payment_id' => $payment_id
        ];

        $sale_id = Sale::insertGetId($sale);

        $discount_id = $order['discount_id'];
        if ($discount_id !== '') {
            $fidelityStep = FidelityStep::whereKey($discount_id)
                ->first();
        }

        $discount_amount = 0;
        if (isset($order['discount_amount'])) {
            $discount_amount = $order['discount_amount'];
            Sale::whereKey($sale_id)
                ->update(['discount_amount' => $order['discount_amount']]);

            unset($order['discount_amount']);
        }
        unset($order['discount_id']);
        unset($order['truck_id']);

        $sum = 0;
        foreach ($order as $dishId => $quantity) {
            $unit_price = $this->get_franchisee_stock($dishId, $user_id)['unit_price'];
            $sold_dish = [
                'dish_id' => $dishId,
                'sale_id' => $sale_id,
                'unit_price' => $unit_price,
                'quantity' => $quantity
            ];
            $sum += $unit_price * $quantity;
            if ($quantity > 0) {
                SoldDish::insert($sold_dish);
            }

            FranchiseeStock::where([
                ['user_id', $user_id],
                ['dish_id', $dishId]
            ])->decrement('quantity', $quantity);
        }

        $subPoint = 0;
        if (!empty($fidelityStep)) {
            $subPoint = $fidelityStep->step;
        }

        $client = User::whereKey($clientId)
            ->first();

        /**
         * client points + 10% of total price as points - points used
         */
        $loyaltyPoint = $sum * 0.1 - $subPoint;
        $toReturn = ceil($loyaltyPoint);
        $loyaltyPoint = $client->loyalty_point + $toReturn;
        if ($loyaltyPoint < 0) {
            $loyaltyPoint = 0;
        }

        User::whereKey($clientId)
            ->update(['loyalty_point' => (int)$loyaltyPoint]);

        Sale::whereKey($sale_id)
            ->update(['points_to_return' => $toReturn]);

        $this->put_loyalty_point_in_session($clientId);

        // invoice creation
        $invoice = ['amount' => $sum,
            'discount_amount' => $discount_amount,
            'date_emitted' => date("Y-m-d"),
            'monthly_fee' => 0,
            'initial_fee' => 0,
            'franchisee_order' => 0,
            'client_order' => 1,
            'user_id' => $client['id'],
            'sale_id' => $sale_id];
        $invoice = Invoice::create($invoice)->toArray();
        $reference = $this->create_invoice_reference('CL', $client['id'], $invoice['id']);
        $this->save_invoice_pdf($invoice['id'], $reference);
        $invoice['reference'] = $reference;
        $this->sendInvoiceMail($client, $invoice);

        flash(trans('client/order.created')
            . ' <a href="' . route('client_sale_display', ['id' => $sale_id]) . '">'
            . trans('client/order.click_here')
            . '</a>.')
            ->success();

        return redirect(route('client_dashboard'));
    }

    public function charge(Request $request, $order_total_cents, $type = '31uV6UZKmoN57tchyQBgfHNZ0pZz1XHYVv7vFdlzyn9jYeO9JbcQ9xKjeZqNfHJe85vqj')
    {
        Session::put('payment_method', $type);
        if ($order_total_cents != 0 && $type == '31uV6UZKmoN57tchyQBgfHNZ0pZz1XHYVv7vFdlzyn9jYeO9JbcQ9xKjeZqNfHJe85vqj') {
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

                Session::put('charge_id', $charge->id);

                return $this->client_order_validate();
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        } else {
            return $this->client_order_validate();
        }
    }

    public function refund($sale_id)
    {
        $sale = Sale::whereKey($sale_id)
            ->first();
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            Refund::create([
                'charge' => $sale->payment_id,
                'reason' => 'requested_by_customer'
            ]);
            return $this->client_order_cancel($sale_id);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function client_sales_history()
    {
        $sales = Sale::where('user_client', $this->get_connected_user()['id'])
            ->with('sold_dishes')
            ->orderBy('date', 'desc')
            ->get();

        if (!empty($sales)) {
            $sales = $sales->toArray();
        }

        $i = 0;
        foreach ($sales as $sale) {
            $sum = 0;
            foreach ($sale['sold_dishes'] as $sold_dish) {
                $sum += $sold_dish['unit_price'] * $sold_dish['quantity'];
            }
            $sales[$i++]['total_price'] = $sum;
        }

        return view('client.order.client_sales_history')
            ->with('sales', $sales);
    }

    public function client_sale_display($sale_id)
    {
        $sale = Sale::whereKey($sale_id)
            ->with('sold_dishes')
            ->with('user_franchised')
            ->first();

        if (!empty($sale)) {
            $sale = $sale->toArray();
        }

        $invoice = Invoice::with('user')->where('sale_id', $sale['id'])->first();
        if (!empty($invoice)) {
            $invoice = $invoice->toArray();
        }

        $sum = 0;
        foreach ($sale['sold_dishes'] as $sold_dish) {
            $sum += $sold_dish['unit_price'] * $sold_dish['quantity'];
        }
        $sale['total_price'] = $sum;

        return view('client.order.client_sale_display')
            ->with('sale', $sale)
            ->with('invoice', $invoice);
    }

    public function stream_client_invoice_pdf($id)
    {
        return $this->stream_invoice_pdf($id);
    }

    public function client_order_cancel($id)
    {
        if (!ctype_digit($id)) {
            $response_array = [
                'status' => 'error',
                'error' => 'warehouse_stock.id_not_digit'
            ];
        } else {
            $errors_list = [];

            $sale = Sale::where([
                ['id', $id],
                ['user_client', $this->get_connected_user()['id']],
            ])->first();

            if ($sale->status == 'pending') {
                if (!empty($sale)) {
                    $sold_dishes = SoldDish::where('sale_id', $id)
                        ->get();

                    Invoice::where('sale_id', $id)->delete();

                    if (!empty($sold_dishes)) {
                        foreach ($sold_dishes as $sold_dish) {
                            FranchiseeStock::where([
                                ['user_id', $sale->user_franchised],
                                ['dish_id', $sold_dish->dish_id]
                            ])->increment('quantity', $sold_dish->quantity);

                            SoldDish::where([
                                ['dish_id', $sold_dish->dish_id],
                                ['sale_id', $sale->id]
                            ])->delete();
                        }
                    }

                    User::whereKey($sale->user_client)
                        ->decrement('loyalty_point', $sale->points_to_return);

                    $this->put_loyalty_point_in_session($sale->user_client);

                    Sale::whereKey($sale->id)
                        ->delete();

                    $response_array = [
                        'status' => 'success'
                    ];
                } else {
                    $errors_list[] = trans('client/order.sale_and_client_do_not_match');

                    $response_array = [
                        'status' => 'error',
                        'errorList' => $errors_list
                    ];
                }
            }
        }

        echo json_encode($response_array);
    }

    public function qr_code($truck_id)
    {
        $truck = Truck::whereKey($truck_id)
            ->with('user')
            ->with('location')
            ->first();

        if (empty($truck)) {
            abort(404);
        }
        $truck = $truck->toArray();

        $text = "Franchisé : " . $truck['user']['pseudo']['name'] . "\n";
        $text .= "Telephone : " . $truck['user']['telephone'] . "\n";
        $text .= "Email : " . $truck['user']['email'] . "\n\n";
        $text .= "Adresse : " . $truck['location']['address'] . ' ' .
            $truck['location']['postcode'] . ' ' .
            $truck['location']['city'] . "\n\n";

        if (!empty($truck['location_date_end'])) {
            $text .= "Jusqu'au : " . $truck['location_date_end'] . "\n";
        }
        $text .= route('client_order', ['truck_id' => $truck_id]);


        $qrCode = \QrCode::format('png')
            ->encoding('UTF-8')
            ->merge(asset('img/logo_transparent_4.png'), 0.4, true)
            ->size(500)
            ->errorCorrection('H')
            ->backgroundColor(0, 89, 120)
            ->margin(2)
            ->color(188, 188, 188)
            ->generate($text);
        return response($qrCode)->header('Content-type', 'image/png');
    }
}