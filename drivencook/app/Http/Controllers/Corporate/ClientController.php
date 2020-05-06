<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Sale;
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
        $client_orders = Sale::where("user_client", $client_id)->with('sold_dishes')->get()->toArray();

        return view('corporate.client.client_view')
            ->with('client', $client)
            ->with('client_orders', $client_orders);
    }

}