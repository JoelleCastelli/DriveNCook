<?php


namespace App\Http\Controllers\Corporate;


use App\Http\Controllers\Controller;
use App\Models\FranchiseeStock;
use App\Models\Invoice;
use App\Models\PurchasedDish;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use App\Models\SoldDish;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\UserTools;
use App\Traits\EmailTools;

class AdministratorController extends Controller
{
    use UserTools;
    use EmailTools;

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
            count($parameters) == 3 && !empty($parameters['lastname']) &&
            !empty($parameters['firstname']) && !empty($parameters['email'])
        ) {
            $lastname = strtoupper($parameters['lastname']);
            $firstname = ucfirst($parameters['firstname']);
            $email = $parameters['email'];

            try {
                $password = substr(str_shuffle(bin2hex(random_bytes(50))), 0, 50);
            } catch (\Exception $e) {
                abort(500);
            }

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
                $token='';
                try {
                    $token = substr(str_shuffle(bin2hex(random_bytes(50))), 0, 50);
                } catch (\Exception $e) {
                    abort(500);
                }

                $admin = [
                    'lastname' => $lastname, 'firstname' => $firstname, 'email' => $email,
                    'role' => 'Administrateur', 'password' => hash('sha256', $password),
                ];

                $id = User::insertGetId($admin);

                $user = User::whereKey($id);

                $user->update(['password_token' => $token]);
                $this->sendNewAccountMail($email, $token);

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

    public function admin_delete($id)
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
}