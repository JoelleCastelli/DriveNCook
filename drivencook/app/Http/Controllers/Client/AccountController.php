<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use DateTime;
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

        $sales = Sale::where('user_client', $clientId)
            ->get();
        $nbSales = count($sales);

        return view('client.client_dashboard')
            ->with('client', $client)
            ->with('nbSales', $nbSales);
    }

    public function registration()
    {
        return view('client.account.registration');
    }

    public function get_client($email) {
        return User::where([
            ['role', 'Client'],
            ['email', $email]
        ])->get();
    }

    public function registration_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (
            count($parameters) == 7 && !empty($parameters['lastname']) &&
            !empty($parameters['firstname']) && !empty($parameters['email']) &&
            !empty($parameters['birthdate']) && !empty($parameters['phone']) &&
            !empty($parameters['password']) && !empty($parameters['password_confirm'])
        ) {
            $lastname = strtoupper($parameters['lastname']);
            $firstname = ucfirst($parameters['firstname']);
            $email = $parameters['email'];
            $birthdate = $parameters['birthdate'];
            $phone = $parameters['phone'];
            $password = $parameters['password'];
            $password_confirm = $parameters['password_confirm'];

            if (strlen($lastname) < 1 || strlen($lastname) > 30) {
                $error = true;
                $errors_list[] = trans('client/registration.lastname_error');
            }

            if (strlen($firstname) < 1 || strlen($firstname) > 30) {
                $error = true;
                $errors_list[] = trans('client/registration.firstname_error');
            }

            if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)
                || strlen($email) > 100) {
                $error = true;
                $errors_list[] = trans('client/registration.email_error');
            }

            $birthdate_split = explode('-', $birthdate);
            if (!checkdate($birthdate_split[1], $birthdate_split[2], $birthdate_split[0])) {
                $error = true;
                $errors_list[] = trans('client/registration.birthdate_error');
            }

            $date1 = new DateTime('01-01-1900');
            $date2 = new DateTime($birthdate);
            if ($date1 > $date2) {
                $error = true;
                $errors_list[] = trans('client/registration.date_timeline_error');
            }

            if (!preg_match('/^[0-9]+$/', $phone) || strlen($phone) > 20) {
                $error = true;
                $errors_list[] = trans('client/registration.phone_error');
            }

            if (!preg_match('/^(?=.*\d)(?=.*[.*@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z.*@#\-_$%^&+=§!\?]{6,100}$/', $password)) {
                $error = true;
                $errors_list[] = trans('client/registration.password_error');
            } else if($password !== $password_confirm) {
                $error = true;
                $errors_list[] = trans('client/registration.password_confirm_error');
            }

            if (!$error) {
                $result = $this->get_client($email);
                if (count($result) != 0) {
                    $error = true;
                    $errors_list[] = trans('client/registration.duplicate_entry_error');
                }
            }

            if ($error) {
                $str = '';
                foreach($errors_list as $error) {
                    $str .= $error . '<br>';
                }
                flash($str)->error();
                return redirect()->back();
            } else {
                $client = [
                    'lastname' => $lastname, 'firstname' => $firstname, 'email' => $email,
                    'role' => 'Client', 'birthdate' => $birthdate, 'telephone' => $phone,
                    'password' => hash('sha256', $password),
                ];
                User::insert($client);
                flash(trans('client/registration.new_client_success'))->success();
                return redirect()->route('client_login');
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

    public function light_registration_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $error = false;
        $errors_list = [];

        if (
            count($parameters) == 5 && !empty($parameters['lastname']) &&
            !empty($parameters['firstname']) && !empty($parameters['email']) &&
            !empty($parameters['password']) && !empty($parameters['password_confirm'])
        ) {
            $lastname = strtoupper($parameters['lastname']);
            $firstname = ucfirst($parameters['firstname']);
            $email = $parameters['email'];
            $password = $parameters['password'];
            $password_confirm = $parameters['password_confirm'];

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

            if (!$error) {
                $result = $this->get_client($email);
                if (count($result) != 0) {
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