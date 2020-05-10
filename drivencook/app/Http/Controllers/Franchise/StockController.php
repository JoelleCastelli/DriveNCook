<?php


namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
use App\Models\FranchiseeStock;
use App\Models\PurchasedDish;
use App\Models\PurchaseOrder;
use App\Traits\EnumValue;
use App\Traits\UserTools;

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
//        var_dump($purchase_order);
//        var_dump($stock);
        return view('franchise.stock.stock_dashboard')
            ->with('stock', $stock)
            ->with('purchase_order', $purchase_order);
    }

    public function stock_order()
    {
        return 'stock_order';
    }

    public function stock_order_submit()
    {
        return 'stock_order_submit';
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
        return 'order view ' . $order_id;
    }

    public function stock_order_warehouse($warehouse_id)
    {
        return 'stock_order_warehouse ' . $warehouse_id;
        //json
    }

    public function stock_update($dish_id)
    {
        return 'stock_update ' . $dish_id;
    }

    public function stock_update_submit()
    {
        return 'stock_update_submit';
    }
}