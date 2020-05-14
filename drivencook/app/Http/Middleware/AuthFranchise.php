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
        return $next($request);
    }
}