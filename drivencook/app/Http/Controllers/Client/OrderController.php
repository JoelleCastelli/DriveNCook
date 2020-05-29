<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthClient;
use App\Models\Dish;
use App\Models\FranchiseeStock;
use App\Models\Truck;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthClient::class);
    }

    public function truck_location_list()
    {
        $trucks = Truck::where('functional', true)
            ->with('user')
            ->with('location')
            ->get();

        if(!empty($trucks)) {
            $trucks = $trucks->toArray();
        }

        return view('client.order.truck_location_list')
            ->with('trucks', $trucks);
    }

    public function client_order($truck_id)
    {
        $truck = Truck::whereKey($truck_id)
            ->with('user')
            ->first();

        if(!empty($truck)) {
            $truck = $truck->toArray();
        }

        $stocks = FranchiseeStock::where('user_id', $truck['user']['id'])
            ->with('dish')
            ->get();

        if(!empty($stocks)) {
            $stocks = $stocks->toArray();
        }

        return view('client.order.client_order')
            ->with('stocks', $stocks);
    }
}