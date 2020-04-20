<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Pseudo;
use App\Models\User;
use Illuminate\Http\Request;

class FranchiseeController extends Controller
{

    public function franchisee_list(){
        $franchisees = User::where('role', 'Franchisé')->get();
        return view('corporate/franchisee/franchisee_list')->with('franchisees', $franchisees);
    }

    public function get_franchisee_by_email($email){
        return User::where([
                ['email', $email],
                ['role', 'Franchisé']
            ])->get();
    }

    public function get_franchisee_by_id($id){
        return User::with('pseudo')->where('id', $id)->first();
    }

    public function franchisee_creation(){
        return view('corporate/franchisee/franchisee_creation');
    }

    public function franchisee_creation_submit(Request $request){
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

            if($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $user = [$lastname, $firstname, $email, $role];
                User::create($user);
                return redirect()->route('franchisee_creation')->with('success', trans('franchisee_creation.new_franchisee_success'));
            }
        }
    }

    public function franchisee_update($id){
        $franchisee = $this->get_franchisee_by_id($id);
        $unavailable_pseudos = User::whereNotNull('pseudo')->get(['pseudo'])->toArray();
        $pseudos = Pseudo::whereNotIn('id', $unavailable_pseudos)->get();
        return view('corporate/franchisee/franchisee_update')->with('franchisee', $franchisee)->with('pseudos', $pseudos);
    }

    public function franchisee_update_submit(Request $request){

        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        var_dump($parameters);

        if (count($parameters) == 8) {
            $firstname = ucwords(strtolower(trim($parameters["firstname"])));
            $lastname = strtoupper(trim($parameters["lastname"]));
            $birthdate = date_create_from_format('Y-m-d', $parameters["birthdate"]);
            $email = strtolower(trim($parameters["email"]));
            $telephone = trim($parameters["telephone"]);
            $driving_licence = trim($parameters["driving_license"]);
            $social_security = trim($parameters["social_security"]);
            $role = "Franchisé";

            // check firstname
            if (strlen($firstname) < 2 || strlen($firstname) > 30) {
                $error = true;
                $errors_list[] = trans('franchisee_update.firstname_error');
            }

            // check lastname
            if (strlen($lastname) < 2 || strlen($lastname) > 30) {
                $error = true;
                $errors_list[] = trans('franchisee_update.lastname_error');
            }

            // check age
            $today = date("Y-m-d");
            $age = date_diff($birthdate, date_create($today))->format('%y');
            if ($age < 18) {
                $error = true;
                $errors_list[] = trans('franchisee_update.too_young');
            } else if ($age > 90) {
                $error = true;
                $errors_list[] = trans('franchisee_update.too_old');
            }

            // check email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = true;
                $errors_list[] = trans('franchisee_update.email_format_error');
            } else if (!$error) {
                $result = $this->get_franchisee_by_email($email);
                if (!empty($result)) {
                    $error = true;
                    $errors_list[] = trans('franchisee_update.email_error');
                }
            }

            // check telephone
            if(!preg_match('/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/', $telephone)) {
                $error = true;
                $errors_list[] = trans('franchisee_update.phone_error');
            }

            // check social security number
            if (strlen($social_security) != 15) {
                $error = true;
                $errors_list[] = trans('franchisee_update.social_security_error');
            }

            // check driving licence number
            if (strlen($driving_licence) > 15) {
                $error = true;
                $errors_list[] = trans('franchisee_update.driving_licence_error');
            }

            if($error) {
                return redirect()->back()->with('error', $errors_list);
            } else {
                $user = [$lastname, $firstname, $email, $role];
                User::create($user);
                return redirect()->route('franchisee_creation')->with('success', trans('franchisee_update.new_franchisee_success'));
            }
        }
    }


    public function test(){
        return view('test');
    }
}