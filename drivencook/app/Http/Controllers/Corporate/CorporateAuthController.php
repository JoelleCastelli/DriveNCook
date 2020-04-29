<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;

class CorporateAuthController extends Controller
{
    public function loginForm()
    {
        return view('corporate.login_page');
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
                'role' => "Corporate"
            ])
            ||
            auth()->attempt([
                'email' => request('email'),
                'password' => request('password'),
                'role' => "Administrateur"
            ]);

        if ($result) {
            flash("Connexion réussi")->success();
            return redirect(route('corporate_dashboard'));
        }

        return back()->withInput()->withErrors([
            'email' => 'Vos identifiants sont incorrects.'
        ]);
    }

    public function logout()
    {
        auth()->logout();
        flash("Déconnexion réussi")->success();
        return redirect(route('corporate_login'));
    }
}