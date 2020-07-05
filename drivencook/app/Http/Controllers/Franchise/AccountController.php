<?php


namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
use App\Models\Pseudo;
use App\Models\User;
use App\Traits\TruckTools;
use App\Traits\UserTools;
use Illuminate\Support\Facades\App;


class AccountController extends Controller
{
    use UserTools;
    use TruckTools;

    public function __construct()
    {
        $this->middleware(AuthFranchise::class);
    }


    public function dashboard()
    {
        $truck = $this->get_franchises_truck($this->get_connected_user()['id']);
        $truckLocation = null;
        if ($truck != null) {
            $truckLocation = $this->get_truck_with_location_only($truck['id']);
        }

        $user = User::with('pseudo')->whereKey($this->get_connected_user()['id'])->first()->toArray();

        $current_month_sales = $this->get_franchise_current_month_sale_revenues($user['id']);

        $invoicing_period = $this->get_invoicing_period($this->get_current_obligation(), "d/m/Y");

        return view('franchise.franchise_dashboard')
            ->with('truck', $truckLocation)
            ->with('revenues', $current_month_sales)
            ->with('invoicing_period', $invoicing_period)
            ->with('franchise', $user);
    }

    public function update_account()
    {
        $franchise = User::whereKey($this->get_connected_user()['id'])
            ->first()->toArray();
        return view('franchise.account_update')
            ->with('franchisee', $franchise);
    }

    public function update_account_submit()
    {
        request()->validate([
            'lastname' => ['required', 'string', 'min:2', 'max:30'],
            'firstname' => ['required', 'string', 'min:2', 'max:30'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email:rfc', 'max:100'],
            'telephone' => ['nullable', 'regex:/^(0|\+[1-9]{2}\s?)[1-9]([-. ]?\d{2}){4}$/u'],
            'driving_licence' => ['required', 'string', 'max:15'],
            'social_security' => ['required', 'string', 'max:15']
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