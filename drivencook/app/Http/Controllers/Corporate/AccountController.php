<?php


namespace App\Http\Controllers\Corporate;

use App\Models\Pseudo;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Traits\UserTools;
use Illuminate\Support\Facades\App;

class AccountController extends Controller
{
    use UserTools;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function dashboard()
    {
        $franchisees = User::where('role', 'Franchisé')->count();
        $warehouses = Warehouse::count();
        $revenues = App::call('App\Http\Controllers\Corporate\FranchiseeController@get_franchisees_current_month_sale_revenues');

        return view('corporate.dashboard')
            ->with('nbfranchisees', $franchisees)
            ->with('nbWarehouses', $warehouses)
            ->with('revenues', $revenues);
    }

    public function update_account()
    {
        $corporate = User::whereKey($this->get_connected_user()['id'])
            ->first()->toArray();
        return view('corporate.account_update')
            ->with('corporate', $corporate);
    }

    public function update_account_submit()
    {
        request()->validate([
            'lastname' => ['required', 'string', 'min:2', 'max:30'],
            'firstname' => ['required', 'string', 'min:2', 'max:30'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email:rfc', 'max:100'],
            'telephone' => ['nullable', 'regex:/^(0|\+[1-9]{2}\s?)[1-9]([-. ]?\d{2}){4}$/u'],
        ]);

        User::whereKey($this->get_connected_user()['id'])
            ->update(request()->except('_token'));
        flash('Compte modifié')->success();
        return back();
    }

    public function update_password()
    {
        request()->validate([
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $this->update_user_password($this->get_connected_user()['id'], request('password'));

        flash('Mot de passe modifié')->success();
        return back();
    }

}