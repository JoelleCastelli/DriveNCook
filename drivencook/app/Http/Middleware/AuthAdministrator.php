<?php


namespace App\Http\Middleware;

use Closure;


class AuthAdministrator
{
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            flash(trans('corporate.must_be_admin'))->error();
            return redirect(route('corporate_login'));
        }

        if (auth()->user()->role != "Administrateur") {
            auth()->logout();
            flash(trans('corporate.must_be_admin'))->error();
            return redirect(route('corporate_login'));
        }
        return $next($request);
    }
}