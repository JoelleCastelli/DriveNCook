<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\FranchiseObligation;
use App\Models\Invoice;
use App\Models\Pseudo;
use App\Models\PurchasedDish;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use App\Models\SoldDish;
use App\Models\FranchiseeStock;
use App\Models\Truck;
use App\Models\User;
use App\Traits\UserTools;
use Illuminate\Http\Request;


class FranchiseeController extends Controller
{
    use UserTools;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function franchisee_list()
    {
        $franchisees = User::with('pseudo')
            ->with('last_paid_invoice_fee')
            ->with('truck')
            ->where('role', 'Franchisé')
            ->get()->toArray();
        $nextPaiement = $this->get_next_payment_date(
            FranchiseObligation::all()->sortByDesc('id')->first()->toArray());

        return view('corporate/franchisee/franchisee_list')
            ->with('franchisees', $franchisees)
            ->with('nextPaiement', $nextPaiement);
    }

    public function get_franchisee_by_email($email)
    {
        $user = User::where([
            ['email', $email],
            ['role', 'Franchisé']
        ])->first();
        if (!empty($user))
            return $user->toArray();
        return null;
    }

    public function franchisee_creation()
    {
        return view('corporate/franchisee/franchisee_creation');
    }

    public function franchisee_creation_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (count($parameters) == 3 && !empty($parameters["lastname"]) && !empty($parameters["firstname"]) && !empty($parameters["email"])) {
            $firstname = ucwords(strtolower(trim($parameters["firstname"])));
            $lastname = strtoupper(trim($parameters["lastname"]));
            $email = strtolower(trim($parameters["email"]));
            $role = "Franchisé";

            // check firstname
            if (strlen($firstname) < 2 || strlen($firstname) > 30) {
                $error = true;
                $errors_list[] = trans('franchisee_creation.firstname_error');
            }

            // check lastname
            if (strlen($lastname) < 2 || strlen($lastname) > 30) {
                $error = true;
                $errors_list[] = trans('franchisee_creation.lastname_error');
            }

            // check email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = true;
                $errors_list[] = trans('franchisee_creation.email_format_error');
            } else if (!$error) {
                $result = $this->get_franchisee_by_email($email);
                if (!empty($result)) {
                    $error = true;
                    $errors_list[] = trans('franchisee_creation.email_error');
                }
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $user = ['lastname' => $lastname, 'firstname' => $firstname, 'email' => $email, 'role' => $role];
                $data = User::create($user);
                $this->generate_first_invoice($data->id);
                return redirect()->route('franchisee_creation')->with('success', trans('franchisee_creation.new_franchisee_success'));
            }
        } else {
            $errors_list[] = trans('franchisee_update.arguments_error');
            return redirect()->back()->with('error', $errors_list);
        }
    }

    public function franchisee_update($id)
    {
        $franchisee = $this->get_franchisee_by_id($id);
        $pseudos = $this->get_available_pseudo_list();

        return view('corporate/franchisee/franchisee_update')->with('franchisee', $franchisee)->with('pseudos', $pseudos);
    }

    public function franchisee_update_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (count($parameters) == 9) {
            $id = trim($parameters["id"]);
            $firstname = ucwords(strtolower(trim($parameters["firstname"])));
            $lastname = strtoupper(trim($parameters["lastname"]));
            $pseudo_id = trim($parameters["pseudo"]);
            $birthdate = date_create_from_format('Y-m-d', $parameters["birthdate"]);
            $email = strtolower(trim($parameters["email"]));
            $telephone = trim($parameters["telephone"]);
            $driving_licence = strtoupper(trim($parameters["driving_licence"]));
            $social_security = strtoupper(trim($parameters["social_security"]));
            $role = "Franchisé";

            // check lastname
            if (strlen($lastname) < 2 || strlen($lastname) > 30) {
                $error = true;
                $errors_list[] = trans('franchisee_update.lastname_error');
            }

            // check firstname
            if (strlen($firstname) < 2 || strlen($firstname) > 30) {
                $error = true;
                $errors_list[] = trans('franchisee_update.firstname_error');
            }

            // check pseudo
            if (!$pseudo_id)
                $pseudo_id = NULL;


            // check age
            if ($birthdate) {
                $today = date("Y-m-d");
                $age = date_diff($birthdate, date_create($today))->format('%y');
                if ($age < 18) {
                    $error = true;
                    $errors_list[] = trans('franchisee_update.too_young');
                } else if ($age > 90) {
                    $error = true;
                    $errors_list[] = trans('franchisee_update.too_old');
                }
            } else {
                $birthdate = NULL;
            }

            // check email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = true;
                $errors_list[] = trans('franchisee_update.email_format_error');
            } else if (!$error) {
                $result = $this->get_franchisee_by_email($email);
                if ($result != null && $result['id'] != $id) {
                    $error = true;
                    $errors_list[] = trans('franchisee_update.email_error');
                }
            }

            // check telephone
            if (strlen($telephone) != 0 && !preg_match('/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/', $telephone)) {
                $error = true;
                $errors_list[] = trans('franchisee_update.phone_error');
            }

            // check social security number
            if (strlen($social_security) != 0 && strlen($social_security) != 15) {
                $error = true;
                $errors_list[] = trans('franchisee_update.social_security_error');
            }

            // check driving licence number
            if (strlen($driving_licence) != 0 && strlen($driving_licence) > 15) {
                $error = true;
                $errors_list[] = trans('franchisee_update.driving_licence_error');
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                User::where('id', $id)->update(['lastname' => $lastname,
                    'firstname' => $firstname,
                    'birthdate' => $birthdate,
                    'pseudo_id' => $pseudo_id,
                    'email' => $email,
                    'telephone' => $telephone,
                    'driving_licence' => $driving_licence,
                    'social_security' => $social_security]);
                return redirect()->back()->with('success', trans('franchisee_update.update_success'));
            }
        } else {
            $errors_list[] = trans('franchisee_update.arguments_error');
            return redirect()->back()->with('error', $errors_list);
        }
    }

    public function franchise_update_password()
    {
        request()->validate([
            'id' => ['required', 'integer'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $this->update_user_password(request('id'), request('password'));

        flash('Mot de passe du franchisé modifié')->success();
        return back();
    }

    public function franchisee_view($id)
    {
        $franchisee = User::whereId($id)
            ->with('pseudo')
            ->with('invoices')
            ->with('truck')
            ->with('stocks')
            ->with('purchase_order')
            ->with('sales')
            ->first()->toArray();

        $revenues = $this->get_franchise_current_month_sale_revenues($id);
        $history = $this->get_franchisee_history([$id]);

        return view('corporate.franchisee.franchisee_view')
            ->with('franchisee', $franchisee)
            ->with('revenues', $revenues)
            ->with('history', $history);
    }

    public function franchisee_stock_orders($id)
    {
        $franchisee = User::whereId($id)
            ->with('pseudo')
            ->with('stocks')
            ->with('purchase_order')
            ->first()->toArray();

        $order_status = $this->get_enum_column_values('purchase_order', 'status');

        return view('corporate.franchisee.franchisee_stocks_orders')
            ->with('order_status', $order_status)
            ->with('franchisee', $franchisee);
    }

    public function franchisee_invoices_list($id)
    {
        $franchisee = User::whereId($id)
            ->with('pseudo')
            ->with('invoices')
            ->first()->toArray();

        $invoices_status = $this->get_enum_column_values('invoice', 'status');

        return view('corporate.franchisee.franchisee_invoices_list')
            ->with('franchisee', $franchisee)
            ->with('invoices_status', $invoices_status);
    }

    public function franchisee_invoice_status_update() {
        request()->validate([
            'invoice_id' => ['required', 'integer'],
            'invoice_status' => ['required', 'string']
        ]);
        Invoice::where([
            ['id', request('invoice_id')]
        ])->update(['status' => request('invoice_status')]);

        return json_encode(array('response' => 'success'));
    }

    public function franchisee_sales_stats($id)
    {
        $franchisee = User::whereId($id)
            ->with('pseudo')
            ->with('sales')
            ->first()->toArray();

        $revenues = $this->get_franchise_current_month_sale_revenues($id);
        $history = $this->get_franchisee_history([$id]);
        $current_obligation = $this->get_current_obligation();
        $invoicing_period = $this->get_invoicing_period($current_obligation, "d/m/Y");

        $sales_chart = $this->generate_chart([$franchisee['id']], 'sales');
        $turnover_chart = $this->generate_chart([$franchisee['id']], 'turnover');
        if($revenues['sales_count'] == 0) {
            $payment_methods_chart = '';
            $origins_chart = '';
        } else {
            $payment_methods_chart = $this->generate_chart([$franchisee['id']], 'payment_methods');
            $origins_chart = $this->generate_chart([$franchisee['id']], 'origin');
        }

        return view('corporate.franchisee.franchisee_sales_stats')
            ->with('franchisee', $franchisee)
            ->with('revenues', $revenues)
            ->with('invoicing_period', $invoicing_period)
            ->with('history', $history)
            ->with('sales_chart', $sales_chart)
            ->with('payment_methods_chart', $payment_methods_chart)
            ->with('origins_chart', $origins_chart)
            ->with('turnover_chart', $turnover_chart);
    }

    public function all_franchisees_sales_stats()
    {

        // Get all id of franchisees with at least one sale
        $franchisees = User::where('role', 'Franchisé')->with('sales')->get();
        $franchisees_ids = [];
        $franchisees_with_sales_ids = [];
        foreach ($franchisees as $user) {
            $franchisees_ids[] = $user->id;
            if($user->sales->count() != 0) {
                $franchisees_with_sales_ids[] = $user->id;
            }
        }

        $revenues = $this->get_franchisees_current_month_sale_revenues();
        $current_obligation = $this->get_current_obligation();
        $invoicing_period = $this->get_invoicing_period($current_obligation, "d/m/Y");
        $history = $this->get_franchisee_history($franchisees_ids);
        $sales_chart = $this->generate_chart($franchisees_with_sales_ids, 'sales');
        $turnover_chart = $this->generate_chart($franchisees_with_sales_ids, 'turnover');
        $payment_methods_chart = $this->generate_chart($franchisees_with_sales_ids, 'payment_methods');
        $origins_chart = $this->generate_chart($franchisees_with_sales_ids, 'origin');

        return view('corporate.global_sales_stats')
            ->with('revenues', $revenues)
            ->with('invoicing_period', $invoicing_period)
            ->with('history', $history)
            ->with('sales_chart', $sales_chart)
            ->with('payment_methods_chart', $payment_methods_chart)
            ->with('origins_chart', $origins_chart)
            ->with('turnover_chart', $turnover_chart);
    }

    public function update_franchise_obligation()
    {
        $last_obligation = FranchiseObligation::all()->sortByDesc('id')->first()->toArray();
        $franchisee_obligations = FranchiseObligation::all()->sortByDesc('id')->toArray();
        foreach ($franchisee_obligations as &$franchisee_obligation) {
            $manager = User::where('id', $franchisee_obligation['user_id'])->first()->toArray();
            $franchisee_obligation['manager'] = $manager['firstname'] . ' ' . $manager['lastname'] . ' (' . $manager['email'] . ')';
        }

        return view('corporate.franchisee.franchisee_obligations_update')
            ->with('obligations', $franchisee_obligations)
            ->with('last_obligation', $last_obligation);
    }

    public function update_franchise_obligation_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (count($parameters) == 4 && !empty($parameters["entrance_fee"]) && !empty($parameters["revenue_percentage"]) && !empty($parameters["warehouse_percentage"]) && !empty($parameters["billing_day"])) {
            $entrance_fee = trim($parameters['entrance_fee']);
            $revenue_percentage = trim($parameters['revenue_percentage']);
            $warehouse_percentage = trim($parameters['warehouse_percentage']);
            $billing_day = trim($parameters['billing_day']);

            $current_obligation = $this->get_current_obligation();
            if ($entrance_fee == $current_obligation['entrance_fee'] &&
                $revenue_percentage == $current_obligation['revenue_percentage'] &&
                $warehouse_percentage == $current_obligation['warehouse_percentage'] &&
                $billing_day == $current_obligation['billing_day']) {
                $errors_list[] = trans('franchisee.values_must_be_different_from_current_obligation');
                return redirect()->back()->with('error', $errors_list);
            }

            if (!is_numeric($entrance_fee) || $entrance_fee < 0 || $entrance_fee > 9999999) {
                $error = true;
                $errors_list[] = trans('franchisee.wrong_initial_fee');
            }
            if (!is_numeric($revenue_percentage) || $revenue_percentage < 0 || $revenue_percentage > 100) {
                $error = true;
                $errors_list[] = trans('franchisee.wrong_monthly_fee');
            }
            if (!is_numeric($warehouse_percentage) || $warehouse_percentage < 0 || $warehouse_percentage > 100) {
                $error = true;
                $errors_list[] = trans('franchisee.wrong_percentage');
            }
            if (!ctype_digit($billing_day) || $billing_day < 1 || $billing_day > 28) {
                $error = true;
                $errors_list[] = trans('franchisee.wrong_billing_day');
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            }

            $manager_id = $this->get_connected_user()['id'];
            $obligation = ['entrance_fee' => $entrance_fee,
                'revenue_percentage' => $revenue_percentage,
                'warehouse_percentage' => $warehouse_percentage,
                'billing_day' => $billing_day,
                'date_updated' => date('Y-m-d'),
                'user_id' => $manager_id];
            FranchiseObligation::insert($obligation);
            return redirect()->route('franchisee_obligation_update')->with('success', trans('franchisee.obligation_updated'));

        } else {
            $errors_list[] = trans('franchisee.request_error');
            return redirect()->back()->with('error', $errors_list);
        }
    }

    public function delete_franchise($id)
    {
        if (!ctype_digit($id)) {
            return 'error';
        }
        Truck::where('user_id', $id)->update(['user_id' => NULL]);
        Invoice::where('user_id', $id)->delete();

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
        return $id;
    }

    public function pseudo_list()
    {
        return view('corporate.franchisee.franchisee_pseudo')
            ->with('pseudos', Pseudo::with('users')->get()->toArray());
    }

    public function pseudo_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        if (empty($parameters['id'])) {
            $response['isNew'] = true;
            $id = Pseudo::insertGetId(['name' => $parameters['name']]);
            $response['id'] = $id;
        } else {
            $response['isNew'] = false;
            $response['id'] = $parameters['id'];
            Pseudo::find($parameters['id'])->update(['name' => $parameters['name']]);
        }

        $response['response'] = 'success';

        return json_encode($response);
    }

    public function pseudo_delete($id)
    {
        User::where('pseudo_id', $id)->update(['pseudo_id' => NULL]);
        Pseudo::find($id)->delete();
        return $id;
    }

    public function get_franchisees_current_month_sale_revenues()
    {
        $franchisees = User::where('role', 'Franchisé')->get()->toArray();
        $total = array(
            "sales_total" => 0,
            "sales_count" => 0,
            "next_invoice" => 0
        );

        foreach ($franchisees as $franchisee) {
            $franchisee_revenues = $this->get_franchise_current_month_sale_revenues($franchisee['id']);

            $total['sales_total'] += $franchisee_revenues['sales_total'];
            $total['sales_count'] += $franchisee_revenues['sales_count'];
            $total['next_invoice'] += $franchisee_revenues['next_invoice'];
        }
        return $total;
    }

    public function stream_franchisee_invoice($id)
    {
        return $this->stream_invoice_pdf($id);
    }

    public function update_franchisee_stock()
    {
        request()->validate([
            'user_id' => ['required', 'integer'],
            'dish_id' => ['required', 'integer'],
            'unit_price' => ['required', 'numeric'],
            'quantity' => ['required', 'integer']
        ]);

        FranchiseeStock::where([
            ['user_id', request('user_id')],
            ['dish_id', request('dish_id')]
        ])->update(request()->except(['user_id', 'dish_id']));

        return json_encode(array('response' => 'success'));
    }

    public function remove_franchisee_stock($user_id, $dish_id)
    {
        if (!ctype_digit($user_id) || !ctype_digit($dish_id)) {
            return json_encode(array('response' => 'error'));
        }
        $stock = FranchiseeStock::where([
            ['user_id', $user_id],
            ['dish_id', $dish_id],
        ])->delete();

        return $dish_id;
    }

    public function update_franchisee_stock_order()
    {
        request()->validate([
            'id' => ['required', 'integer'],
            'status' => ['required', 'string']
        ]);

        PurchaseOrder::whereKey(request('id'))->update(['status' => request('status')]);

        return json_encode(array('response' => 'success'));

    }

    public function remove_franchisee_stock_order($purchase_order_id)
    {
        if (!ctype_digit($purchase_order_id)) {
            return json_encode(array('response' => 'error'));
        }
        PurchasedDish::where('purchase_order_id', $purchase_order_id)->delete();
        PurchaseOrder::whereKey($purchase_order_id)->delete();

        return $purchase_order_id;
    }

}