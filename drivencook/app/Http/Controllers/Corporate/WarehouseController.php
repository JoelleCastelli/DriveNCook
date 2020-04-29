<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
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
}