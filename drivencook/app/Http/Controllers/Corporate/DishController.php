<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\FranchiseeStock;
use App\Models\PurchasedDish;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use App\Models\SoldDish;
use App\Models\WarehousStock;
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
        $stats_categories = [];
        $stats_diets = [];

        $dishes = Dish::get()->toArray();

        $dish_categories = $this->get_enum_column_values('dish', 'category');
        foreach($dish_categories as $dish_category) {
            $stats_categories[$dish_category] = count(Dish::where('category', $dish_category)->get()->toArray());
        }

        $dish_diets = $this->get_enum_column_values('dish', 'diet');
        foreach($dish_diets as $dish_diet) {
            $stats_diets[$dish_diet] = count(Dish::where('diet', $dish_diet)->get()->toArray());
        }

        return view('corporate/dish/dish_list')
            ->with('dishes', $dishes)
            ->with('stats_categories', $stats_categories)
            ->with('stats_diets', $stats_diets);
    }

    public function dish_delete($id) {

        if (!ctype_digit($id)) {
            return 'error';
        }

        $purchased_dishes = PurchasedDish::where('dish_id', $id);
        if (!empty($purchased_dishes)) {
            PurchasedDish::whereIn('dish_id', $purchased_dishes->get()->toArray())
                ->delete();
            PurchaseOrder::whereIn('id', $purchased_dishes->get(['purchase_order_id'])->toArray())
                           ->delete();
        }

        $sold_dishes = SoldDish::where('dish_id', $id);
        if (!empty($sold_dishes)) {
            SoldDish::whereIn('dish_id', $sold_dishes->get()->toArray())
                ->delete();
            Sale::whereIn('id', $sold_dishes->get(['sale_id'])->toArray())
                        ->delete();
        }

        WarehousStock::where('dish_id', $id)->delete();
        FranchiseeStock::where('dish_id', $id)->delete();
        Dish::where('id', $id)->delete();

        return $id;
    }

    public function dish_creation() {
        $categories = $this->get_enum_column_values('dish', 'category');
        $diets = $this->get_enum_column_values('dish', 'diet');
        return view('corporate/dish/dish_creation')->with('categories', $categories)
                                                              ->with('diets', $diets);
    }

    public function dish_creation_submit(Request $request) {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (count($parameters) == 4 && !empty($parameters["name"]) && !empty($parameters["category"])
                                    && !empty($parameters["diet"])) {

            $name = trim($parameters["name"]);
            $category = $parameters["category"];
            $diet = $parameters["diet"];
            $description = $parameters["description"];

            // check name
            if (strlen($name) < 2 || strlen($name) > 30) {
                $error = true;
                $errors_list[] = trans('dish.name_error');
            }

            // check if already in database
            $existing_dish = Dish::where('name', $name)->first();
            if($existing_dish) {
                $error = true;
                $errors_list[] = trans('dish.already_exist');
            }

            // check description
            if (strlen($description) > 255) {
                $error = true;
                $errors_list[] = trans('dish.description_error');
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $dish = ['name' => $name, 'category' => $category, 'description' => $description, 'diet' => $diet];
                Dish::create($dish);
                return redirect()->back()->with('success', trans('dish.creation_success'));


                $data = User::create($user);
            }
        } else {
            $errors_list[] = trans('dish.arguments_error');
            return redirect()->back()->with('error', $errors_list);
        }
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
            $name = trim($parameters["name"]);
            $category = $parameters["category"];
            $diet = $parameters["diet"];
            $description = $parameters["description"];

            // check name
            if (strlen($name) < 2 || strlen($name) > 30) {
                $error = true;
                $errors_list[] = trans('dish.name_error');
            }

            // if new name, check if already in database
            $current_dish = Dish::where('id', $id)->first()->toArray();
            if($current_dish['name'] != $name) {
                $existing_dish = Dish::where('name', $name)->first();
                if($existing_dish) {
                    $error = true;
                    $errors_list[] = trans('dish.already_exist');
                }
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