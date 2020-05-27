<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthClient;
use App\Models\Dish;
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

    public function client_order()
    {
        $dishes = Dish::all();

        if(!empty($dishes)) {
            $dishes = $dishes->toArray();
        }

        return view('client.order.client_order')
            ->with('dishes', $dishes);
    }
}