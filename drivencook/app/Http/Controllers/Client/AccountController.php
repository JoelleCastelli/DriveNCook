<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\EventInvited;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\UserTools;

class AccountController extends Controller
{
    use UserTools;

    public function dashboard()
    {
        $clientId = $this->get_connected_user()['id'];
        $client = User::whereKey($clientId)
            ->first();

        $last_sale = Sale::where('user_client', $clientId)
            ->with('user_franchised')
            ->orderBy('date', 'desc')
            ->first();

        if(!empty($last_sale)) {
            $last_sale = $last_sale->toArray();
        }

        return view('client.client_dashboard')
            ->with('client', $client)
            ->with('sale', $last_sale);
    }

    public function registration()
    {
        return view('client.account.registration');
    }


    public function get_client_by_email($email) {
        $user = User::where([
            ['email', $email],
            ['role', 'Client']
        ])->first();

        if (!empty($user))
            return $user->toArray();
        return null;
    }

    public function light_registration_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (
            count($parameters) == 6 && !empty($parameters['lastname']) &&
            !empty($parameters['firstname']) && !empty($parameters['email']) &&
            !empty($parameters['password']) && !empty($parameters['password_confirm'])
        ) {
            $lastname = strtoupper($parameters['lastname']);
            $firstname = ucfirst($parameters['firstname']);
            $email = $parameters['email'];
            $password = $parameters['password'];
            $password_confirm = $parameters['password_confirm'];
            $g_recaptcha_response = $parameters['g-recaptcha-response'];

            if (strlen($lastname) < 2 || strlen($lastname) > 30) {
                $error = true;
                $errors_list[] = trans('client/registration.lastname_error');
            }

            if (strlen($firstname) < 2 || strlen($firstname) > 30) {
                $error = true;
                $errors_list[] = trans('client/registration.firstname_error');
            }

            if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)
                || strlen($email) > 100) {
                $error = true;
                $errors_list[] = trans('client/registration.email_format_error');
            }

            if (!preg_match('/^(?=.*\d)(?=.*[.*@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z.*@#\-_$%^&+=§!\?]{6,100}$/', $password)) {
                $error = true;
                $errors_list[] = trans('client/registration.password_error');
            } else if($password !== $password_confirm) {
                $error = true;
                $errors_list[] = trans('client/registration.password_confirm_error');
            }

            $ip = $_SERVER['REMOTE_ADDR'];
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".env('CAPTCHA_SECRET_KEY')."&response=".$g_recaptcha_response."&remoteip=".$ip);
            $responseKeys = json_decode($response,true);
            if(intval($responseKeys["success"]) !== 1) {
                $error = true;
                $errors_list[] = trans('client/registration.captcha_error');
            }

            if (!$error) {
                $result = $this->get_client_by_email($email);
                if ($result != null) {
                    $error = true;
                    $errors_list[] = trans('client/registration.duplicate_entry_error');
                }
            }

            if ($error) {
                return back()->withInput()->withErrors(['client_registration' => $errors_list]);
            } else {
                $client = [
                    'lastname' => $lastname, 'firstname' => $firstname, 'email' => $email,
                    'role' => 'Client', 'password' => hash('sha256', $password),
                ];
                User::insert($client);
                return back()->withInput()->withErrors(
                    ['client_registration_success' => trans('client/registration.new_client_success')]
                );
            }
        } else {
            $errors_list[] = trans('client/registration.empty_fields');
            $str = '';
            foreach($errors_list as $error) {
                $str .= $error . '<br>';
            }
            flash($str)->error();
            return redirect()->back();
        }
    }

    public function account() {
        $client = User::whereKey($this->get_connected_user()['id'])
            ->first();

        if(!empty($client)) {
            $client->toArray();
        }

        return view('client.account.update')
            ->with('client', $client);
    }

    public function update_account_submit() {
        request()->validate([
            'lastname' => ['required', 'string', 'min:2', 'max:30'],
            'firstname' => ['required', 'string', 'min:2', 'max:30'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email:rfc', 'max:100'],
            'telephone' => ['nullable', 'regex:/^(0|\+[1-9]{2}\s?)[1-9]([-. ]?\d{2}){4}$/u'],
            'opt_in' => ['required', 'boolean'],
        ]);

        User::whereKey($this->get_connected_user()['id'])
            ->update(request()->except('_token'));

        flash(trans('client/account.update_successful'))->success();

        return back();
    }

    public function update_account_password()
    {
        request()->validate([
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $this->update_user_password($this->get_connected_user()['id'], request('password'));

        flash(trans('client/account.update_password_successful'))->success();
        return back();
    }

    public function delete_account()
    {
        Sale::where("user_client", $this->get_connected_user()['id'])->delete();
        $this->delete_user($this->get_connected_user()['id']);
    }
}