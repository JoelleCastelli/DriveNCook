<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Http\Request;
use App\Traits\EnumValue;

class DishController extends Controller
{
    use EnumValue;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function get_dish_by_name($dishName)
    {
        return Dish::where('name', $dishName)->get();
    }

    public function dish_creation_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        $categories = $this->get_enum_column_values('dish', 'category');

        if (
            count($parameters) == 5 && !empty($parameters["warehouseId"]) &&
            !empty($parameters["name"]) && !empty($parameters["category"]) &&
            !empty($parameters["quantity"]) && !empty($parameters["warehousePrice"])
        ) {
            $name = $parameters["name"];
            $category = $parameters["category"];
            $quantity = intval($parameters["quantity"]);
            $warehousePrice = $parameters["warehousePrice"];
            $warehouseId = intval($parameters["warehouseId"]);

            if (strlen($name) < 1 || strlen($name) > 30) {
                $error = true;
                $errors_list[] = trans('dish_creation.name_error');
            }

            if(!in_array($category, $categories)) {
                $error = true;
                $errors_list[] = trans('dish_creation.category_error');
            }

            if (!is_int($quantity)) {
                $error = true;
                $errors_list[] = trans('dish_creation.quantity_error');
            }

            if(!is_numeric($warehousePrice)) {
                $error = true;
                $errors_list[] = trans('dish_creation.dish_price_error');
            }

            if (!is_int($warehouseId) && $warehouseId > 0) {
                $error = true;
                $errors_list[] = trans('dish_creation.warehouse_id_error');
            }

            if (count($this->get_dish_by_name($name)) > 0) {
                $error = true;
                $errors_list[] = trans('dish_creation.duplicate_entry_error');
            }

            if ($error) {
                $response_array = [
                    'status' => 'error',
                    'errorList' => $errors_list
                ];
            } else {
                $dish = [
                    'name' => $name, 'category' => $category,
                    'quantity' => $quantity, 'warehouse_price' => $warehousePrice,
                    'warehouse_id' => $warehouseId
                ];
                $lastId = Dish::insertGetId($dish);

                $response_array = [
                    'status' => 'success',
                    'data' => Dish::find($lastId)
                ];
            }
        } else {
            $errors_list[] = trans('dish_creation.empty_fields');

            $response_array = [
                'status' => 'error',
                'errorList' => $errors_list
            ];
        }
        echo json_encode($response_array);
    }

    public function dish_update_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        $categories = $this->get_enum_column_values('dish', 'category');

        if (
            count($parameters) == 5 && !empty($parameters["id"]) &&
            !empty($parameters["name"]) && !empty($parameters["category"]) &&
            !empty($parameters["quantity"]) && !empty($parameters["warehousePrice"])
        ) {
            $id = $parameters["id"];
            $name = $parameters["name"];
            $category = $parameters["category"];
            $quantity = intval($parameters["quantity"]);
            $warehousePrice = $parameters["warehousePrice"];

            if (strlen($name) < 1 || strlen($name) > 30) {
                $error = true;
                $errors_list[] = trans('dish_update.name_error');
            }

            if(!in_array($category, $categories)) {
                $error = true;
                $errors_list[] = trans('dish_update.category_error');
            }

            if (!is_int($quantity)) {
                $error = true;
                $errors_list[] = trans('dish_update.quantity_error');
            }

            if(!is_numeric($warehousePrice)) {
                $error = true;
                $errors_list[] = trans('dish_update.dish_price_error');
            }

            if ($error) {
                $response_array = [
                    'status' => 'error',
                    'errorList' => $errors_list
                ];
            } else {
                $dish = [
                    'name' => $name, 'category' => $category,
                    'quantity' => $quantity, 'warehouse_price' => $warehousePrice
                ];
                Dish::find($id)->update($dish);

                $response_array = [
                    'status' => 'success',
                    'data' => Dish::find($id)
                ];
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

    public function dish_delete($id)
    {
        if (!ctype_digit($id)) {
            $response_array = [
                'status' => 'error',
                'error' => 'dish_delete.id_not_digit'
            ];
        } else {
            Dish::find($id)->delete();

            $response_array = [
                'status' => 'success'
            ];
        }

        echo json_encode($response_array);
    }
}