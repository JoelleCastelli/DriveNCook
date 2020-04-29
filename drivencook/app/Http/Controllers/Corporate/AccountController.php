<?php


namespace App\Http\Controllers\Corporate;

use App\Models\Pseudo;
use App\Models\User;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function dashboard()
    {
        $franchisees = User::where('role', 'Franchisé')->count();
//        $franchisees = User::with('pseudo')->where('role', 'Franchisé')->first();
//        var_dump($franchisees->getRelation('pseudo')->name);die;
        return view('corporate.dashboard')->with('nbfranchisees', $franchisees);
    }
}