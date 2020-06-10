<?php


namespace App\Http\Controllers\Corporate;


use App\Http\Controllers\Controller;
use App\Models\User;

class AdministratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthAdministrator');
    }

    public function user_list()
    {
        $users = User::all();

        if(!empty($users)) {
            $users = $users->toArray();
        }

        return view('corporate.administrator.administrator_user_list')
            ->with('users', $users);
    }
}