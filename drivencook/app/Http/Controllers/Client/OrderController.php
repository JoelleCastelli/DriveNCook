<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthClient;
use App\Models\FranchiseeStock;
use App\Models\Sale;
use App\Models\SoldDish;
use App\Models\Truck;
use Illuminate\Http\Request;
use App\Traits\UserTools;
use App\Traits\TruckTools;
use App\Traits\StockTools;

class OrderController extends Controller
{
    use UserTools;
    use TruckTools;
    use StockTools;

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

        $stocks = FranchiseeStock::where([
            ['user_id', $truck['user']['id']],
            ['menu', true]
        ])->with('dish')
            ->with('user')
            ->get();

        if(!empty($stocks)) {
            $stocks = $stocks->toArray();
        }

        return view('client.order.client_order')
            ->with('stocks', $stocks);
    }

    public function check_order_array($array): bool
    {
        if($array['truck_id']) {
            $truck = Truck::whereKey($array['truck_id'])
                ->with('user')
                ->first();

            if(!empty($truck)) {
                $truck = $truck->toArray();
            }

            unset($array['truck_id']);

            foreach($array as $dishId => $quantity) {
                $result = FranchiseeStock::where([
                    ['user_id', $truck['user']['id']],
                    ['dish_id', $dishId],
                    ['menu', true]
                ])->get();

                if(!(count($result) > 0)) {
                    return false;
                } else if($quantity > $result[0]['quantity']) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    public function client_order_submit(Request $request)
    {
        $parameters = $request->all();
        $errors_list = [];

        if(!empty($parameters['order'])) {
            $parameters['order'] = get_object_vars(json_decode($parameters['order']));

            if($this->check_order_array($parameters['order'])) {
                $userId = $this->get_truck_with_franchisee_by_truck_id($parameters['order']['truck_id'])['user']['id'];

                $sale = [
                    'online_order' => true,
                    'user_franchised' => $userId,
                    'user_client' => $this->get_connected_user()['id'],
                    'status' => 'pending'
                ];

                $saleId = Sale::insertGetId($sale);

                unset($parameters['order']['truck_id']);

                foreach($parameters['order'] as $dishId => $quantity) {
                    $sold_dish = [
                        'dish_id' => $dishId,
                        'sale_id' => $saleId,
                        'unit_price' => $this->get_franchisee_stock($dishId, $userId)['unit_price'],
                        'quantity' => $quantity,
                    ];

                    if($quantity > 0) {
                        SoldDish::insert($sold_dish);
                    }
                }

                $response_array = [
                    'status' => 'success'
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
}