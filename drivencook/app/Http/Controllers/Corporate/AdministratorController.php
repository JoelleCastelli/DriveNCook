<?php


namespace App\Http\Controllers\Corporate;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthAdministrator');
    }

    public function get_admin_by_email($email) {
        $user = User::where([
            ['email', $email],
            ['role', 'Administrateur']
        ])->first();

        if (!empty($user))
            return $user->toArray();
        return null;
    }

    public function admin_list()
    {
        $users = User::where('role', 'Administrateur')
            ->get();

        if(!empty($users)) {
            $users = $users->toArray();
        }

        return view('corporate.administrator.administrator_admin_list')
            ->with('users', $users);
    }

    public function admin_creation()
    {
        return view('corporate.administrator.administrator_creation');
    }

    public function admin_creation_submit(Request $request)
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
                $errors_list[] = trans('administrator/creation.lastname_error');
            }

            if (strlen($firstname) < 2 || strlen($firstname) > 30) {
                $error = true;
                $errors_list[] = trans('administrator/creation.firstname_error');
            }

            if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)
                || strlen($email) > 100) {
                $error = true;
                $errors_list[] = trans('administrator/creation.email_format_error');
            }

            if (!preg_match('/^(?=.*\d)(?=.*[.*@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z.*@#\-_$%^&+=§!\?]{6,100}$/', $password)) {
                $error = true;
                $errors_list[] = trans('administrator/creation.password_error');
            } else if($password !== $password_confirm) {
                $error = true;
                $errors_list[] = trans('administrator/creation.password_confirm_error');
            }

            if (!$error) {
                $result = $this->get_admin_by_email($email);
                if ($result != null) {
                    $error = true;
                    $errors_list[] = trans('administrator/creation.duplicate_entry_error');
                }
            }

            if ($error) {
                return back()->withInput()->withErrors(['admin_creation' => $errors_list]);
            } else {
                $admin = [
                    'lastname' => $lastname, 'firstname' => $firstname, 'email' => $email,
                    'role' => 'Administrateur', 'password' => hash('sha256', $password),
                ];
                User::insert($admin);
                return back()->withInput()->withErrors(
                    ['admin_creation_success' => trans('administrator/creation.new_admin_success')]
                );
            }
        } else {
            $errors_list[] = trans('administrator/creation.empty_fields');
            $str = '';
            foreach($errors_list as $error) {
                $str .= $error . '<br>';
            }
            flash($str)->error();
            return redirect()->back();
        }
    }
}