<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FranchiseeController extends Controller
{

    public function franchisee_list(){
        $franchisees = User::where('role', 'Franchisé')->get();
        return view('corporate/franchisee/franchisee_list')->with('franchisees', $franchisees);
    }

    public function get_franchisee_by_email($email){
        return User::where('email', $email)->get();
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

            if (strlen($firstname) < 2 || strlen($firstname) > 30) {
                $error = true;
                $errors_list[] = trans('franchisee_creation.firstname_error');
            }

            if (strlen($lastname) < 2 || strlen($lastname) > 30) {
                $error = true;
                $errors_list[] = trans('franchisee_creation.lastname_error');
            }

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

    public function test(){
        return view('test');
    }
}