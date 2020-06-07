<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthClient;
use App\Models\FranchiseeStock;
use App\Models\FidelityStep;
use App\Models\Sale;
use App\Models\SoldDish;
use App\Models\Truck;
use App\Models\User;
use Carbon\Carbon;
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

        $fidelity_step = '';

        if(!empty($stocks)) {
            $stocks = $stocks->toArray();

            $fidelity_step = FidelityStep::where('user_id', $stocks[0]['user']['id'])
                ->orderBy('reduction')
                ->get();

            if(!empty($fidelity_step)) {
                $fidelity_step = $fidelity_step->toArray();
            }
        }

        $client = User::whereKey($this->get_connected_user())
            ->first();

        if(!empty($client)) {
            $client = $client->toArray();
        }

        return view('client.order.client_order')
            ->with('stocks', $stocks)
            ->with('promotions', $fidelity_step)
            ->with('client', $client);
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
                    'date' => Carbon::now()->toDateString(),
                    'user_franchised' => $userId,
                    'user_client' => $this->get_connected_user()['id'],
                    'status' => 'pending'
                ];

                $saleId = Sale::insertGetId($sale);

                unset($parameters['order']['truck_id']);

                $sum = 0;
                foreach($parameters['order'] as $dishId => $quantity) {
                    $unitPrice = $this->get_franchisee_stock($dishId, $userId)['unit_price'];
                    $sold_dish = [
                        'dish_id' => $dishId,
                        'sale_id' => $saleId,
                        'unit_price' => $unitPrice,
                        'quantity' => $quantity,
                    ];
                    $sum += $unitPrice;
                    if($quantity > 0) {
                        SoldDish::insert($sold_dish);
                    }
                }

                $loyaltyPoint = $sum * 0.1;

                User::whereKey($this->get_connected_user()['id'])
                    ->update(['loyalty_point' => (int)$loyaltyPoint]);

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

    public function client_sales_history()
    {
        $sales = Sale::where('user_client', $this->get_connected_user()['id'])
            ->with('sold_dishes')
            ->get();

        if(!empty($sales)) {
            $sales = $sales->toArray();
        }

        $i = 0;
        foreach($sales as $sale) {
            $sum = 0;
            foreach($sale['sold_dishes'] as $sold_dish) {
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

        if(!empty($sale)) {
            $sale = $sale->toArray();
        }

        $sum = 0;
        foreach($sale['sold_dishes'] as $sold_dish) {
            $sum += $sold_dish['unit_price'] * $sold_dish['quantity'];
        }
        $sale['total_price'] = $sum;

        return view('client.order.client_sale_display')
            ->with('sale', $sale);
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

            if (!empty($sale)) {
                $sold_dishes = SoldDish::where('sale_id', $id)
                    ->get();

                if (!empty($sold_dishes)) {
                    foreach ($sold_dishes as $sold_dish) {
                        SoldDish::where([
                            ['dish_id', $sold_dish->dish_id],
                            ['sale_id', $sale->id]
                        ])->delete();
                    }
                }
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

        echo json_encode($response_array);
    }
}