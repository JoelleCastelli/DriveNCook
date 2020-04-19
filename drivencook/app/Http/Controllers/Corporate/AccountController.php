<?php


namespace App\Http\Controllers\Corporate;
use App\Models\User;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function dashboard()
    {
        $franchisees = User::where('role', 'Franchisé')->get();
        return view('corporate.dashboard')->with('franchisees', $franchisees);
    }
}