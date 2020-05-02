<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Http\Request;
use App\Traits\EnumValue;

class DishController extends Controller
{
    use EnumValue;

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
                return redirect()->back()->with('error', $errors_list);
            } else {
                $dish = [
                    'name' => $name, 'category' => $category,
                    'quantity' => $quantity, 'warehouse_price' => $warehousePrice
                ];
                Dish::find($id)->update($dish);
                $response_array['status'] = 'success';
                //return redirect()->back()->with('success', trans('dish_update.update_dish_success'));
            }
        } else {
            $errors_list[] = trans('dish_update.empty_fields');

            $response_array = [
                'status' => 'error',
                'errorList' => $errors_list
            ];
            //return redirect()->back()->with('error', $errors_list);
        }
        echo json_encode($response_array);
    }
}