<?php


namespace App\Http\Controllers\Corporate;

use App\Models\Pseudo;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function dashboard()
    {
        $franchisees = User::where('role', 'Franchisé')->count();
        $revenues = App::call('App\Http\Controllers\Corporate\FranchiseeController@get_franchisees_current_month_sale_revenues');

        return view('corporate.dashboard')
            ->with('nbfranchisees', $franchisees)
            ->with('revenues', $revenues);
    }
}