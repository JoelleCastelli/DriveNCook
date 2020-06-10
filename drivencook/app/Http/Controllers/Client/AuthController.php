<?php


namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthClient;


class AuthController extends Controller
{
    public function loginForm()
    {
        return view('client.client_login');
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
                'role' => "Client"
            ])
            ||
            auth()->attempt([
                'email' => request('email'),
                'password' => request('password'),
                'role' => "Administrateur"
            ]);

        if ($result) {
            return back();
        }

        return back()->withInput()->withErrors(['client_login' => trans('auth.failed')]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect(route('homepage'));
    }
}