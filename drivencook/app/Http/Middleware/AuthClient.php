<?php


namespace App\Http\Middleware;

use Closure;


class AuthClient
{
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            flash(trans('auth.try_client_with_client_not_connected'))->error();
            return redirect(route('client_login'));
        }

        if (auth()->user()->role != "Client" && auth()->user()->role != "Administrateur") {
            auth()->logout();
            flash(trans('auth.try_client_with_client_not_connected'))->error();
            return redirect(route('client_login'));
        }
        return $next($request);
    }
}