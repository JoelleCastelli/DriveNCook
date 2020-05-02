<?php


namespace App\Http\Middleware;

use Closure;


class AuthCorporate
{
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            flash("Vous devez être connecté en tant que Corporate pour acceder à cette page")->error();
            return redirect(route('corporate_login'));
        }

        if (auth()->user()->role != "Corporate" && auth()->user()->role != "Administrateur") {
            auth()->logout();
            flash("Vous devez être connecté en tant que Corporate pour acceder à cette page")->error();
            return redirect(route('corporate_login'));
        }
        return $next($request);
    }
}