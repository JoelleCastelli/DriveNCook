<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Invoice;
use App\Models\Location;
use App\Models\PurchasedDish;
use App\Models\PurchaseOrder;
use App\Models\Warehouse;
use App\Models\WarehousStock;
use App\Traits\EnumValue;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    use EnumValue;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function warehouse_creation()
    {
        $warehouses_locations = [];
        $warehouses = Warehouse::all()->toArray();
        foreach ($warehouses as $warehouse) {
            $warehouses_locations[] = $warehouse['location_id'];
        }

        $locations = Location::whereNotIn('id', $warehouses_locations)->get();
        if (!empty($locations)) {
            $locations = $locations->toArray();
        }

        return view('corporate/warehouse/warehouse_creation')->with('locations', $locations);
    }

    public function warehouse_creation_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        // Check that only one address option has been selected
        if($parameters["existing_location_id"] != null && $parameters["new_address_full"] != null) {
            $errors_list = ['Please select only one option'];
            return redirect()->back()->with('error', $errors_list);
        }

        if (count($parameters) == 9) {
            $warehouse_name = $parameters["warehouse_name"];
            $existing_location_id = $parameters["existing_location_id"];
            $new_address['full_name'] = $parameters["new_address_full"];
            $new_address['latitude'] = $parameters["new_address_lat"];
            $new_address['longitude'] = $parameters["new_address_lon"];
            $new_address['address'] = $parameters["new_address_address"];
            $new_address['city'] = $parameters["new_address_city"];
            $new_address['postcode'] = $parameters["new_address_postcode"];
            $new_address['country'] = $parameters["new_address_country"];

            if (strlen($warehouse_name) == 0) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.enter_name');
            }

            if (strlen($warehouse_name) > 30) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.name_error');
            }

            // Check that warehouse name is not already in warehouse DB
            $duplicate = Warehouse::where('name', $warehouse_name)->first();
            if ($duplicate != null) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.duplicate_entry_error');
            }

            if($existing_location_id != null) { // Option 1: selection of existing location

                // Check that location ID is not already associated to another warehouse
                $duplicate = Warehouse::where('location_id', $existing_location_id)->first();
                if ($duplicate != null) {
                    $error = true;
                    $errors_list[] = trans('warehouse_creation.existing_warehouse_on_location');
                }

            } else { // Option 2: location creation

                if (strlen($new_address['address']) < 1 || strlen($new_address['address']) > 100) {
                    $error = true;
                    $errors_list[] = trans('warehouse_creation.address_error');
                }
                if (strlen($new_address['city']) > 50) {
                    $error = true;
                    $errors_list[] = 'Error, incorrect city name size';
                }
                if (strlen($new_address['postcode']) > 7) {
                    $errors_list[] = 'Error, incorrect postcode size';
                }
                if (strlen($new_address['country']) > 50) {
                    $errors_list[] = 'Error, incorrect country name size';
                }

                // Check that there's no location name duplicate
                $duplicate = Location::where('name', $warehouse_name)->first();
                if ($duplicate != null) {
                    $error = true;
                    $errors_list[] = trans('warehouse_creation.existing_location_name');
                }

                // Check that there's no location lat/lon duplicate
                $duplicate = Location::where([
                    ['latitude', $new_address['latitude']],
                    ['longitude', $new_address['longitude']]
                ])->first();

                if ($duplicate != null) {
                    $error = true;
                    $errors_list[] = trans('warehouse_creation.existing_location', ['location_name' => $duplicate->toArray()['name']]);
                }
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                if($existing_location_id != null) {
                    $location_id = $existing_location_id;
                } else {
                    $location_id = Location::insertGetId([
                        'name' => $warehouse_name,
                        'address' => $new_address['address'],
                        'city' => $new_address['city'],
                        'postcode' => $new_address['postcode'],
                        'country' => $new_address['country'],
                        'latitude' => $new_address['latitude'],
                        'longitude' => $new_address['longitude']
                    ]);
                }
                $warehouse = ['name' => $warehouse_name, 'location_id' => $location_id];
                Warehouse::create($warehouse);
                return redirect()->route('warehouse_creation')->with('success', trans('warehouse_creation.new_warehouse_success'));
            }
        } else {
            $errors_list[] = trans('warehouse_creation.empty_fields');
            return redirect()->back()->with('error', $errors_list);
        }
    }

    public function warehouse_update($warehouse_id)
    {
        $warehouse = Warehouse::find($warehouse_id);
        if (empty($warehouse))
            return view('corporate.warehouse.warehouse_list');
        $warehouse = $warehouse->toArray();

        $warehouses_locations = Warehouse::where('id', '!=', $warehouse['id'])->pluck(('location_id'))->toArray();

        $locations = Location::whereNotIn('id', $warehouses_locations)->get();
        if (!empty($locations)) {
            $locations = $locations->toArray();
        }

        return view('corporate.warehouse.warehouse_update')
            ->with('locations', $locations)
            ->with('warehouse', $warehouse);
    }

    public function warehouse_update_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (count($parameters) == 3 && !empty($parameters["id"]) && !empty($parameters["name"])
                                    && !empty($parameters["location_id"])) {
            $id = $parameters["id"];
            $name = $parameters["name"];
            $location_id = $parameters["location_id"];

            if (strlen($name) < 1 || strlen($name) > 30) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.name_error');
            }

            if (Location::where('id', $location_id)->get() == null) {
                $error = true;
                $errors_list[] = trans('warehouse_creation.city_error');
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $warehouse = [
                    'name' => $name, 'location_id' => $location_id
                ];
                Warehouse::find($id)->update($warehouse);
                return redirect()->route('warehouse_update', ['id' => $id])->with('success', trans('warehouse_update.update_warehouse_success'));
            }
        } else {
            $errors_list[] = trans('warehouse_creation.empty_fields');
            return redirect()->back()->with('error', $errors_list);
        }
    }

    public function warehouse_list(){
        $warehouses = Warehouse::with('location')
            ->get()->toArray();
        return view('corporate.warehouse.warehouse_list')->with('warehouses', $warehouses);
    }

    public function warehouse_view($id)
    {
        $warehouse = Warehouse::whereKey($id)
            ->with('location')
            ->with('stock')
            ->with('purchase_order')
            ->first();

        if (!empty($warehouse)) {
            $warehouse = $warehouse->toArray();

            $i = 0;
            foreach ($warehouse['purchase_order'] as $purchaseOrder) {
                $orderPrice = 0;
                foreach ($purchaseOrder['purchased_dishes'] as $item) {
                    $orderPrice += $item['unit_price'] * $item['quantity'];
                }
                $warehouse['purchase_order'][$i++] += ['order_price' => $orderPrice];
            }
        }

        $out_of_stock = false;
        foreach($warehouse['stock'] as $dish) {
            if ($dish['quantity'] <= 5) {
                $out_of_stock = true;
                break;
            }
        }

        return view('corporate.warehouse.warehouse_view')
            ->with('out_of_stock', $out_of_stock)
            ->with('warehouse', $warehouse);
    }

    public function warehouse_delete($warehouse_id)
    {
        if (!ctype_digit($warehouse_id)) {
            return 'error';
        }

        WarehousStock::where('warehouse_id', $warehouse_id)->delete();
        $purchase_orders = PurchaseOrder::where('warehouse_id', $warehouse_id);
        PurchasedDish::whereIn('purchase_order_id', $purchase_orders->pluck('id'))->delete();
        Invoice::whereIn('purchase_order_id', $purchase_orders->pluck('id'))->delete();
        $purchase_orders->delete();

        Warehouse::find($warehouse_id)->delete();
        return $warehouse_id;
    }

    public function warehouse_dishes($id)
    {
        $warehouse = Warehouse::whereKey($id)
            ->with('stock')
            ->first();
        if (!empty($warehouse)) {
            $warehouse = $warehouse->toArray();
        }

        $categories = $this->get_enum_column_values('dish', 'category');
        $warehouse_stock_dishes_id = WarehousStock::where('warehouse_id', $warehouse['id'])->get()->pluck('dish_id')->toArray();
        $dishes = Dish::whereNotIn('id', $warehouse_stock_dishes_id)->get()->toArray();

        return view('corporate.warehouse.warehouse_dishes')
            ->with('warehouse', $warehouse)
            ->with('dishes', $dishes)
            ->with('categories', $categories);
    }

    public function warehouse_order($warehouseId, $id)
    {
        $order = PurchaseOrder::whereKey($id)
            ->with('purchased_dishes')
            ->with('user')
            ->first();
        if (!empty($order)) {
            $order = $order->toArray();
        }

        $orderPrice = 0;
        foreach ($order['purchased_dishes'] as $item) {
            $orderPrice += $item['unit_price'] * $item['quantity'];
        }

        return view('corporate.warehouse.warehouse_order')
            ->with('order', $order)
            ->with('orderPrice', $orderPrice);
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
            if (!empty($purchasedDish)) {
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
                    if (!empty($dishesArray)) {
                        $dishesArray->toArray();
                    }

                    $sum = 0;
                    foreach ($dishesArray as $dish) {
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

    public function warehouse_stock_creation_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (count($parameters) == 4 && !empty($parameters["warehouseId"]) && !empty($parameters["id"])
            && !empty($parameters["quantity"]) && !empty($parameters["warehousePrice"])) {
            $dish_id = $parameters["id"];
            $quantity = intval($parameters["quantity"]);
            $warehouse_price = $parameters["warehousePrice"];
            $warehouseId = intval($parameters["warehouseId"]);

            $dish = Dish::where('id', $dish_id)->first();
            if(!empty($dish)) {
                $dish = $dish->toArray();

                if (!is_int($quantity)) {
                    $error = true;
                    $errors_list[] = trans('warehouse_stock.quantity_error');
                }

                if(!is_numeric($warehouse_price)) {
                    $error = true;
                    $errors_list[] = trans('warehouse_stock.warehouse_price_error');
                }

                if (!is_int($warehouseId) && $warehouseId > 0) {
                    $error = true;
                    $errors_list[] = trans('warehouse_stock.warehouse_id_error');
                }

                if ($error) {
                    $response_array = [
                        'status' => 'error',
                        'errorList' => $errors_list
                    ];
                } else {
                    $stock = [
                        'quantity' => $quantity, 'warehouse_price' => $warehouse_price,
                        'warehouse_id' => $warehouseId, 'dish_id' => $dish_id
                    ];

                    WarehousStock::where([
                        ['warehouse_id', $warehouseId],
                        ['dish_id', $dish_id]
                    ])->insert($stock);

                    $warehouseStock = WarehousStock::where([
                        ['warehouse_id', $warehouseId],
                        ['dish_id', $dish_id]
                    ])->with('dish')->first();
                    if(!empty($warehouseStock)) {
                        $warehouseStock = $warehouseStock->toArray();
                        $warehouseStock['dish']['category'] = trans($GLOBALS['DISH_TYPE'][$warehouseStock['dish']['category']]);

                        $response_array = [
                            'status' => 'success',
                            'data' => $warehouseStock
                        ];
                    } else {
                        $errors_list[] = trans('warehouse_stock.warehouse_stock_not_find_error');

                        $response_array = [
                            'status' => 'error',
                            'errorList' => $errors_list
                        ];
                    }
                }
            } else {
                $errors_list[] = trans('warehouse_stock.dish_not_exist_error');

                $response_array = [
                    'status' => 'error',
                    'errorList' => $errors_list
                ];
            }
        } else {
            $errors_list[] = trans('warehouse_stock.empty_fields');

            $response_array = [
                'status' => 'error',
                'errorList' => $errors_list
            ];
        }
        echo json_encode($response_array);
    }

    public function warehouse_stock_update_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (
            count($parameters) == 4 && !empty($parameters["dishId"]) &&
            !empty($parameters["quantity"]) && !empty($parameters["warehousePrice"]) &&
            !empty($parameters['warehouseId'])
        ) {
            $dishId = intval($parameters["dishId"]);
            $quantity = intval($parameters["quantity"]);
            $warehouse_price = $parameters["warehousePrice"];
            $warehouse_id = intval($parameters["warehouseId"]);

            if (!is_int($quantity)) {
                $error = true;
                $errors_list[] = trans('warehouse_stock.quantity_error');
            }

            if(!is_numeric($warehouse_price)) {
                $error = true;
                $errors_list[] = trans('warehouse_stock.warehouse_price_error');
            }

            if ($error) {
                $response_array = [
                    'status' => 'error',
                    'errorList' => $errors_list
                ];
            } else {
                $stock = [
                    'quantity' => $quantity, 'warehouse_price' => $warehouse_price
                ];
                WarehousStock::where([
                    ['warehouse_id', $warehouse_id],
                    ['dish_id', $dishId]
                ])->update($stock);

                $warehouseStock = WarehousStock::where([
                    ['warehouse_id', $warehouse_id],
                    ['dish_id', $dishId]
                ])->first();
                if(!empty($warehouseStock)) {
                    $warehouseStock = $warehouseStock->toArray();
                }

                $response_array = [
                    'status' => 'success',
                    'data' => $warehouseStock
                ];
            }
        } else {
            $errors_list[] = trans('warehouse_stock.empty_fields');

            $response_array = [
                'status' => 'error',
                'errorList' => $errors_list
            ];
        }
        echo json_encode($response_array);
    }

    public function warehouse_stock_delete($dish_id, $warehouse_id)
    {
        if (!ctype_digit($dish_id) || !ctype_digit($warehouse_id)) {
            $response_array = [
                'status' => 'error',
                'error' => 'warehouse_stock.id_not_digit'
            ];
        } else {
            WarehousStock::where([
                ['warehouse_id', $warehouse_id],
                ['dish_id', $dish_id]
            ])->delete();

            $response_array = [
                'status' => 'success'
            ];
        }

        echo json_encode($response_array);
    }
}