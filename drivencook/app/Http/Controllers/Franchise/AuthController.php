<?php


namespace App\Http\Controllers\Franchise;


use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
use App\Traits\UserTools;
use Illuminate\Support\Facades\App;


class AuthController extends Controller
{
    public function loginForm()
    {
        return view('franchise.franchise_login');
    }

    public function processLoginForm()
    {
        //https://laravel.com/docs/5.5/validation#available-validation-rules

        request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $result = auth()->attempt([
                'email' => request('email'),
                'password' => request('password'),
                'role' => "Franchisé"
            ])
            ||
            auth()->attempt([
                'email' => request('email'),
                'password' => request('password'),
                'role' => "Administrateur"
            ]);

        if ($result) {
            flash("Connexion réussie")->success();
            return redirect(route('franchise.dashboard'));
        }

        return back()->withInput()->withErrors([
            'email' => 'Vos identifiants sont incorrects.'
        ]);
    }

    public function logout()
    {
        auth()->logout();
        flash("Déconnexion réussie")->success();
        return redirect(route('franchise.login'));
    }
}