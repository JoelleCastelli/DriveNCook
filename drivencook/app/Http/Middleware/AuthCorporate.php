<?php


namespace App\Http\Middleware;

use Closure;


class AuthCorporate
{
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            flash(trans('corporate.must_be_corporate'))->error();
            return redirect(route('corporate_login'));
        }

        if (auth()->user()->role != "Corporate" && auth()->user()->role != "Administrateur") {
            auth()->logout();
            flash(trans('corporate.must_be_corporate'))->error();
            return redirect(route('corporate_login'));
        }
        return $next($request);
    }
}