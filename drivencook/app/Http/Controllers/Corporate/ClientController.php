<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function client_list()
    {
        $client_list = User::where('role', 'Client')->get()->toArray();
        $sale_count = Sale::where("date", ">=", Carbon::today()->subDays(30))->count();

        return view('corporate.client.client_list')
            ->with('client_list', $client_list)
            ->with('sale_count', $sale_count);
    }

    public function add_client()
    {

    }

    public function add_client_submit()
    {

    }

    public function update_client($client_id)
    {
        return 'coucou';
    }

    public function update_client_submit()
    {

    }

    public function delete_client($client_id)
    {

    }

    public function view_client($client_id)
    {
        $client = User::find($client_id)->toArray();
        $client_orders = $this->process_client_sales($client_id);
//        var_dump($client_orders);
//        die;

        return view('corporate.client.client_view')
            ->with('client', $client)
            ->with('client_orders', $client_orders);
    }

    public function process_client_sales($client_id)
    {
        $sales = Sale::where("user_client", $client_id)
            ->with('sold_dishes')
            ->with('user_franchised')
            ->get()->toArray();
        for ($i = 0; $i < count($sales); $i++) {
            $franchisee_id = $sales[$i]['user_franchised']['id'];
            for ($j = 0; $j < count($sales[$i]['sold_dishes']); $j++) {
                $price = Stock::where([
                    ['user_id', $franchisee_id],
                    ['dish_id', $sales[$i]['sold_dishes'][$j]['dish_id']]
                ])->get(['unit_price'])->first()->unit_price;
                $sales[$i]['sold_dishes'][$j]['unit_price'] = $price;
            }
        }
        return $sales;
    }

}