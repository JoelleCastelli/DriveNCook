<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\FranchiseObligation;
use App\Models\Pseudo;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FranchiseeController extends Controller
{

    public function franchisee_list()
    {
        $franchisees = User::with('pseudo')
            ->with('last_paid_licence_fee')
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
        return $user;
    }

    public function get_franchisee_by_id($id)
    {
        return User::with('pseudo')->where('id', $id)->first()->toArray();
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
                User::insert($user);
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
            if(!$pseudo_id)
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
                if ($result['id'] != $id) {
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

    public function franchisee_view($id)
    {
        $franchisee = User::whereId($id)
            ->with('pseudo')
            ->with('monthly_licence_fees')
            ->first()->toArray();
        return view('corporate.franchisee.franchisee_view')->with('franchisee', $franchisee);
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
        var_dump($parameters);
        die;
    }
}