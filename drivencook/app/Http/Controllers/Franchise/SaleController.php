<?php


namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Sale;
use App\Traits\UserTools;

class SaleController extends Controller
{
    use UserTools;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthFranchise');
    }

    public function dashboard()
    {
        $sales = Sale::where('user_franchised', $this->get_connected_user()['id'])
            ->with('sold_dishes')
            ->with('user_client')
            ->orderBy('date', 'desc')
            ->get()->toArray();

        $i = 0;
        foreach ($sales as $sale) {
            $nbproduct = 0;
            $sum = 0;
            foreach ($sale['sold_dishes'] as $sold_dish) {
                $sum += $sold_dish['unit_price'] * $sold_dish['quantity'];
                $nbproduct += $sold_dish['quantity'];
            }
            $sales[$i]['nb_product'] = $nbproduct;
            $sales[$i++]['total_price'] = $sum;
        }
        return view('franchise.sale.client_sales_dashboard')
            ->with('sales', $sales);
    }

    public function view_client_sale($sale_id)
    {
        $sale = Sale::whereKey($sale_id)
            ->with('sold_dishes')
            ->with('user_client')
            ->first();

        if (empty($sale)) {
            abort(404);
        }
        $sale = $sale->toArray();

        $sum = 0;
        foreach ($sale['sold_dishes'] as $sold_dish) {
            $sum += $sold_dish['unit_price'] * $sold_dish['quantity'];
        }
        $sale['total_price'] = $sum;

        $sale_status = $this->get_enum_column_values('sale', 'status');
        return view('franchise.sale.client_sale_display')
            ->with('sale', $sale)
            ->with('sale_status', $sale_status);
    }

    public function update_client_sale_status()
    {
        request()->validate([
            'sale_id' => ['required', 'integer'],
            'status' => ['required', 'string']
        ]);
        Sale::whereKey(request('sale_id'))->update(['status' => request('status')]);

        flash(trans('franchisee.order_status_updated'));

        return back();
    }

}