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
use App\Models\Stock;
use App\Models\Truck;
use App\Models\User;
use App\Traits\UserTools;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
        $nextPaiement = $this->getNextPaiementDate(
            FranchiseObligation::all()->sortByDesc('id')->first()->toArray());

        return view('corporate/franchisee/franchisee_list')
            ->with('franchisees', $franchisees)
            ->with('nextPaiement', $nextPaiement);
    }

    public function getNextPaiementDate($franchiseObligation)
    {
        $currentDay = new DateTime();
        $currentDay->setDate(date('Y'), date('m'), date('d'));

        if ($currentDay->format('d') <= $franchiseObligation['billing_day']) {
            return $currentDay
                ->setDate(date('Y'), date('m'), $franchiseObligation['billing_day'])
                ->format('d-m-Y');
        }
        return $currentDay
            ->setDate(date('Y'), date('m'), $franchiseObligation['billing_day'])
            ->modify('+1 month')
            ->format('d-m-Y');
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

    public function get_franchisee_by_id($id)
    {
        $user = User::with('pseudo')->where('id', $id)->first();
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
                User::create($user);
                return redirect()->route('franchisee_creation')->with('success', trans('franchisee_creation.new_franchisee_success'));
            }
        }
    }

    public function franchisee_update($id)
    {
        $franchisee = $this->get_franchisee_by_id($id);
        $unavailable_pseudos = User::whereNotNull('pseudo_id')->get(['pseudo_id'])->toArray();
        $pseudos = Pseudo::whereNotIn('id', $unavailable_pseudos)->get()->toArray();

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
                    'driving_licence' => $driving_licence]);
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

        return view('corporate.franchisee.franchisee_view')
            ->with('franchisee', $franchisee)
            ->with('revenues', $revenues);
    }

    public function update_franchise_obligation()
    {
        $last_obligation = FranchiseObligation::all()->sortByDesc('id')->first()->toArray();
        $franchisee_obligations = FranchiseObligation::all()->sortByDesc('id')->toArray();
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

            if (!ctype_digit($entrance_fee) || $entrance_fee < 0 || $entrance_fee > 9999999) {
                $error = true;
                $errors_list[] = 'Frais d\'entrées incorrect';
            }
            if (!ctype_digit($revenue_percentage) || $revenue_percentage < 0 || $revenue_percentage > 100) {
                $error = true;
                $errors_list[] = 'Taxes sur les revenues incorrect';
            }
            if (!ctype_digit($warehouse_percentage) || $warehouse_percentage < 0 || $warehouse_percentage > 100) {
                $error = true;
                $errors_list[] = 'Taxes sur les entrepôts incorrect';
            }
            if (!ctype_digit($billing_day) || $billing_day < 1 || $billing_day > 28) {
                $error = true;
                $errors_list[] = 'Jour de facturation mensuel incorrect';
            }

            if ($error) {
                return redirect()->back()->with('error', $errors_list);
            }

            $obligation = ['entrance_fee' => $entrance_fee,
                'revenue_percentage' => $revenue_percentage,
                'warehouse_percentage' => $warehouse_percentage,
                'billing_day' => $billing_day,
                'date_updated' => date('Y-m-d')];
            FranchiseObligation::insert($obligation);
            return redirect()->route('franchisee_obligation_update')->with('success', 'Obligations du franchisé mises à jour !');

        } else {
            $errors_list[] = 'Erreur dans la requête Post !';
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
        Stock::where('user_id', $id)->delete();
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

    public function get_franchise_current_month_sale_revenues($franchise_id)
    {
        $franchise_obligation = FranchiseObligation::all()->sortByDesc('id')->first()->toArray();
        $date_max = DateTime::createFromFormat("d-m-Y", $this->getNextPaiementDate($franchise_obligation));
        $date_min = clone $date_max;
        $date_min->modify('-1 month');

        $date_max = $date_max->format("Y-m-d");
        $date_min = $date_min->format("Y-m-d");

        $stocks = Stock::where('user_id', $franchise_id)->get()->toArray();

        $sales = Sale::whereBetween('date', [$date_min, $date_max])->with('sold_dishes')->get()->toArray();
        $sales_total = 0;
        $purchase_orders = PurchaseOrder::whereBetween('date', [$date_min, $date_max])->with('purchased_dishes')->get()->toArray();
        $purchase_orders_total = 0;

        foreach ($sales as $sale) {
            foreach ($sale['sold_dishes'] as $sold_dish) {
                $unit_price = 0;
                foreach ($stocks as $stock) {
                    if ($stock['dish_id'] == $sold_dish['dish_id']) {
                        $unit_price = $stock['unit_price'];
                        break;
                    }
                }
                $sales_total += $sold_dish['quantity'] * $unit_price;
            }
        }

        foreach ($purchase_orders as $purchase_order) {
            foreach ($purchase_order['purchased_dishes'] as $purchased_dish) {
                $purchase_orders_total += $purchased_dish['dish']['warehouse_price'] * $purchased_dish['quantity'];
            }
        }

        return array(
            "sales_total" => $sales_total,
            "sales_count" => count($sales),
            "purchase_orders_total" => $purchase_orders_total,
            "purchase_orders_count" => count($purchase_orders),
            "revenues" => $sales_total - $purchase_orders_total,
            "obligation" => $franchise_obligation
        );
    }

    public function get_franchisees_current_month_sale_revenues()
    {
        $franchisees = User::where('role', 'Franchisé')->get()->toArray();
        $total = array(
            "sales_total" => 0,
            "sales_count" => 0,
            "purchase_orders_total" => 0,
            "purchase_orders_count" => 0,
            "revenues" => 0,
            "obligation" => 0
        );

        foreach ($franchisees as $franchisee) {
            $franchisee_revenues = $this->get_franchise_current_month_sale_revenues($franchisee['id']);

            $total['sales_total'] += $franchisee_revenues['sales_total'];
            $total['sales_count'] += $franchisee_revenues['sales_count'];
            $total['purchase_orders_total'] += $franchisee_revenues['purchase_orders_total'];
            $total['purchase_orders_count'] += $franchisee_revenues['purchase_orders_count'];
            $total['revenues'] += $franchisee_revenues['revenues'];
            $total['obligation'] = $franchisee_revenues['obligation'];
        }
        return $total;
    }

    public function franchisee_invoice_pdf($id)
    {
        $invoice = Invoice::with('user')->where('id', $id)->first()->toArray();
        $pseudo = Pseudo::where('id', $invoice['user']['pseudo_id'])->first()->toArray();
        $pdf = PDF::loadView('corporate.franchisee.franchisee_invoice', array('invoice' => $invoice, 'pseudo' => $pseudo));
        return $pdf->stream();
    }
}