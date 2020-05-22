<?php


namespace App\Http\Middleware;

use Closure;


class AuthFranchise
{
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            flash("Vous devez être connecté.e en tant que Franchisé pour accéder à cette page")->error();
            return redirect(route('franchise.login'));
        }

        if (auth()->user()->role != "Franchisé" && auth()->user()->role != "Administrateur") {
            auth()->logout();
            flash("Vous devez être connecté.e en tant que Franchisé pour accéder à cette page")->error();
            return redirect(route('franchise.login'));
        }

        if (empty(auth()->user()->driving_licence)
            || empty(auth()->user()->social_security)
            || empty(auth()->user()->telephone)) {
            flash("Vous devez completer vos informations pour accéder à votre compte")->warning();
            request()->session()->put('email_registration',auth()->user()->email);
            return redirect(route('franchise.complete_registration'));
        }

        return $next($request);
    }
}