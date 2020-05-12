<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Traits\EnumValue;
use Illuminate\Http\Request;

class DishController extends Controller
{
    use EnumValue;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function dish_list() {
        $dishes = Dish::get()->toArray();

        return view('corporate/dish/dish_list')
            ->with('dishes', $dishes);
    }

    public function delete_dish($id) {
        /*if (!ctype_digit($id)) {
            return 'error';
        }

        $purchaseOrder = PurchaseOrder::where('user_id', $id)->get(['id']);
        if (!empty($purchaseOrder)) {
            PurchasedDish::whereIn('dish_id', $purchaseOrder->toArray())->delete();
            PurchaseOrder::where('user_id', $id)->delete();
        }

        $sale = Sale::where('user_franchised', $id)->get(['id']);
        if (!empty($sale)) {
            SoldDish::whereIn('dish_id', $sale->toArray())->delete();
            Sale::where('user_franchised', $id)->delete();
        }
        FranchiseeStock::where('user_id', $id)->delete();
        $this->delete_user($id);

        Dish::where('id', $id)->delete();*/
        return $id;
    }

    public function dish_update($id) {
        $dish = Dish::where('id', $id)->first()->toArray();
        $categories = $this->get_enum_column_values('dish', 'category');
        $diets = $this->get_enum_column_values('dish', 'diet');
        return view('corporate/dish/dish_update')->with('dish', $dish)
                                                      ->with('categories', $categories)
                                                      ->with('diets', $diets);
    }

    public function dish_update_submit(Request $request) {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (count($parameters) == 5 && !empty($parameters["name"]) && !empty($parameters["category"])
                                    && !empty($parameters["diet"])) {

            $id = trim($parameters["id"]);
            $name = ucwords(strtolower(trim($parameters["name"])));
            $category = $parameters["category"];
            $diet = $parameters["diet"];
            $description = $parameters["description"];

            // check name
            if (strlen($name) < 2 || strlen($name) > 30) {
                $error = true;
                $errors_list[] = trans('dish.name_error');
            }

            // check description
            if (strlen($description) > 255) {
                $error = true;
                $errors_list[] = trans('dish.description_error');
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                Dish::where('id', $id)->update(['name' => $name,
                                                'category' => $category,
                                                'diet' => $diet,
                                                'description' => $description]);
                return redirect()->back()->with('success', trans('dish.update_success'));
            }
        } else {
            $errors_list[] = trans('dish.arguments_error');
            return redirect()->back()->with('error', $errors_list);
        }
    }

}