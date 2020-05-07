<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\PurchasedDish;
use App\Models\PurchaseOrder;
use App\Models\Warehouse;
use App\Traits\EnumValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    use EnumValue;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function warehouse_creation() {
        $cities = City::all();
        if (!empty($cities)) {
            $cities = $cities->toArray();
        }
        return view('corporate/warehouse/warehouse_creation')->with('cities', $cities);
    }

    public function get_warehouse($name) {
        return Warehouse::where('name', $name)->get();
    }

    public function get_city($id) {
        return count(City::where('id', $id)->get());
    }

    public function warehouse_creation_submit(Request $request) {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (
            count($parameters) == 3 && !empty($parameters["name"]) && !empty($parameters["address"]) && !empty($parameters["city"])
        ) {
            $name = strtoupper($parameters["name"]);
            $address = strtoupper($parameters["address"]);
            $city_id = $parameters["city"];

            if (strlen($name) < 1 || strlen($name) > 30) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.name_error');
            }

            if($this->get_city($city_id) == 0) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.city_error');
            }

            if (strlen($address) < 1 || strlen($address) > 100 || !preg_match('/^[A-Za-z -_]+$/', $address)) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.address_error');
            }

            if (!$error) {
                $result = $this->get_warehouse($name);
                if (count($result) != 0) {
                    $error = true;
                    $errors_list[] = trans('warehouse_creation.duplicate_entry_error');
                }
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $warehouse = [
                    'name' => $name, 'address' => $address, 'city_id' => $city_id
                ];
                Warehouse::insert($warehouse);
                return redirect()->route('warehouse_creation')->with('success', trans('warehouse_creation.new_warehouse_success'));
            }
        } else {
            $errors_list[] = trans('warehouse_creation.empty_fields');
            return redirect()->back()->with('error', $errors_list);
        }
    }

    public function warehouse_update($id) {
        $warehouse = Warehouse::find($id);
        if (empty($warehouse))
            return view('corporate.warehouse.warehouse_list');
        $warehouse = $warehouse->toArray();

        $cities = City::all();
        if (!empty($cities)) {
            $cities = $cities->toArray();
        }

        return view('corporate.warehouse.warehouse_update')
            ->with('cities', $cities)
            ->with('warehouse', $warehouse);
    }

    public function warehouse_update_submit(Request $request) {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (
            count($parameters) == 4 &&
            !empty($parameters["name"]) && !empty($parameters["address"]) &&
            !empty($parameters["city"]) && !empty($parameters["id"])
        ) {
            $id = $parameters["id"];
            $name = strtoupper($parameters["name"]);
            $address = strtoupper($parameters["address"]);
            $city_id = $parameters["city"];

            if (strlen($name) < 1 || strlen($name) > 30) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.name_error');
            }

            if($this->get_city($city_id) == 0) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.city_error');
            }

            if (strlen($address) < 1 || strlen($address) > 100 || !preg_match('/^[A-Za-z -_]+$/', $address)) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.address_error');
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $warehouse = [
                    'name' => $name, 'address' => $address, 'city_id' => $city_id
                ];
                Warehouse::find($id)->update($warehouse);
                return redirect()->route('warehouse_update', ['id' => $id])->with('success', trans('warehouse_update.update_warehouse_success'));
            }
        } else {
            $errors_list[] = trans('warehouse_creation.empty_fields');
            return redirect()->back()->with('error', $errors_list);
        }
    }

    public function warehouse_list()
    {
        $warehouses = Warehouse::with('city')
            ->get()->toArray();
        return view('corporate.warehouse.warehouse_list')->with('warehouses', $warehouses);
    }

    public function warehouse_view($id)
    {
        //select * from purchase_order PO left join purchased_dish PD on PO.id = PD.purchase_order_id
        // left join dish d on PD.dish_id = d.id where d.warehouse_id = 1;
        /*$orders = DB::table('purchase_order')
            ->select('purchase_order.*', 'purchased_dish.quantity as pd_quantity', 'purchased_dish.*', 'dish.*')
            ->leftJoin('purchased_dish', 'purchase_order.id', '=', 'purchased_dish.purchase_order_id')
            ->leftJoin('dish', 'purchased_dish.dish_id', '=', 'dish.id')
            ->where('dish.warehouse_id', '=', $id)
            ->get();*/
        $orders = DB::table('purchase_order')
            ->select('purchase_order.*', 'purchase_order.id as p_o_id', 'pseudo.*')
            ->leftJoin('user', 'user_id', '=', 'user.id')
            ->leftJoin('pseudo', 'user.pseudo_id', '=', 'pseudo.id')
            ->distinct()
            ->get();
        if(!empty($orders)) {
            $orders->toArray();
        }

        $warehouse = Warehouse::whereId($id)
            ->with('city')
            ->with('dishes')
            ->first()->toArray();

        return view('corporate.warehouse.warehouse_view')
            ->with('warehouse', $warehouse)
            ->with('orders', $orders);
    }

    public function warehouse_delete($id)
    {
        if (!ctype_digit($id)) {
            return 'error';
        }
        Warehouse::find($id)->delete();
        return $id;
    }

    public function warehouse_dishes($id)
    {
        $warehouse = Warehouse::whereId($id)
            ->with('dishes')
            ->first();
        if(!empty($warehouse)) {
            $warehouse->toArray();
        }

        $categories = $this->get_enum_column_values('dish', 'category');
        return view('corporate.warehouse.warehouse_dishes')
            ->with('warehouse', $warehouse)
            ->with('categories', $categories);
    }

    public function warehouse_order($warehouseId, $id)
    {
        $order = DB::table('purchase_order')
        ->select('purchase_order.*', 'purchase_order.id as po_id',
            'purchased_dish.*', 'purchased_dish.quantity as pd_quantity',
            'dish.*')
        ->leftJoin('purchased_dish', 'purchase_order.id', '=', 'purchased_dish.purchase_order_id')
        ->leftJoin('dish', 'purchased_dish.dish_id', '=', 'dish.id')
        ->where('purchase_order.id', '=', $id)
        ->get();
        if(!empty($order)) {
            $order->toArray();
        }

        $franchisee = DB::table('user')
            ->select('pseudo.name', 'user.firstname', 'user.lastname', 'user.email')
            ->leftJoin('purchase_order', 'user_id', '=', 'user.id')
            ->leftJoin('pseudo', 'user.pseudo_id', '=', 'pseudo.id')
            ->where('purchase_order.id', '=', $id)
            ->get();
        if(!empty($franchisee)) {
            $franchisee->toArray();
        }

        return view('corporate.warehouse.warehouse_order')
            ->with('order', $order)
            ->with('franchisee', $franchisee)
            ->with('warehouseId', $warehouseId);
    }

    public function warehouse_order_update_product_qty_sent(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (
            count($parameters) == 3 && !empty($parameters["purchase_order_id"]) &&
            !empty($parameters["dish_id"]) && !empty($parameters["quantitySent"])
        ) {
            $purchase_order_id = $parameters["purchase_order_id"];
            $dish_id = $parameters["dish_id"];
            $quantity = intval($parameters["quantitySent"]);

            $purchasedDish = PurchasedDish::where([
                ['purchase_order_id', '=', $purchase_order_id],
                ['dish_id', '=', $dish_id],
            ])->first();
            if(!empty($purchasedDish)) {
                if (!is_int($quantity) || $quantity < 1 || $quantity > $purchasedDish->quantity) {
                    $error = true;
                    $errors_list[] = trans('dish_update.quantity_error');
                }

                if ($error) {
                    $response_array = [
                        'status' => 'error',
                        'errorList' => $errors_list
                    ];
                } else {
                    $product = [
                        'quantity_sent' => $purchasedDish->quantity_sent + $quantity,
                    ];
                    PurchasedDish::where([
                        ['purchase_order_id', '=', $purchase_order_id],
                        ['dish_id', '=', $dish_id],
                    ])->update($product);

                    $dishesArray = PurchasedDish::where('purchase_order_id', '=', $purchase_order_id)->get();
                    if(!empty($dishesArray)) {
                        $dishesArray->toArray();
                    }

                    $sum = 0;
                    foreach($dishesArray as $dish) {
                        $sum += $dish['quantity_sent'] - $dish['quantity'];
                    }

                    $orderStatus = [
                        'status' => $sum == 0 ? 'sent' : 'in_progress'
                    ];
                    PurchaseOrder::find($purchase_order_id)
                        ->update($orderStatus);

                    $finalOrderStatus = PurchaseOrder::find($purchase_order_id)->first();

                    $response_array = [
                        'status' => 'success',
                        'data' => PurchasedDish::where([
                            ['purchase_order_id', '=', $purchase_order_id],
                            ['dish_id', '=', $dish_id],
                        ])->first(),
                        'purchaseOrder' => trans($GLOBALS['PURCHASE_ORDER_STATUS'][$finalOrderStatus['status']])
                    ];
                }
            } else {
                $errors_list[] = trans('dish_update.wrong_ids');
            }
        } else {
            $errors_list[] = trans('dish_update.empty_fields');

            $response_array = [
                'status' => 'error',
                'errorList' => $errors_list
            ];
        }

        echo json_encode($response_array);
    }
}