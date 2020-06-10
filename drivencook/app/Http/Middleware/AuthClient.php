<?php


namespace App\Http\Middleware;

use Closure;

class AuthClient
{
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            return redirect(route('homepage'))->withErrors(
                ['client_login_necessary' => trans('auth.try_client_with_client_not_connected')]
            );
        }

        if (auth()->user()->role != "Client" && auth()->user()->role != "Administrateur") {
            auth()->logout();
            return redirect(route('homepage'))->withErrors(
                ['client_login_necessary' => trans('auth.try_client_with_client_not_connected')]
            );
        }
        return $next($request);
    }
}