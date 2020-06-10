<?php


namespace App\Http\Middleware;

use Closure;


class AuthFranchise
{
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            return redirect(route('homepage'))->withErrors(
                ['franchisee_login_necessary' => trans('auth.try_franchisee_not_connected')]
            );
        }

        if (auth()->user()->role != "Franchisé" && auth()->user()->role != "Administrateur") {
            auth()->logout();
            return redirect(route('homepage'))->withErrors(
                ['franchisee_login_necessary' => trans('auth.try_franchisee_not_connected')]
            );
        }

        if (empty(auth()->user()->driving_licence)
            || empty(auth()->user()->social_security)
            || empty(auth()->user()->telephone)
            || empty(auth()->user()->pseudo_id)) {
            request()->session()->put('email_registration', auth()->user()->email);
            return redirect(route('franchise.complete_registration'))->withErrors(
                ['franchisee_complete_registration_necessary' => trans('auth.try_franchisee_not_completed')]
            );
        }

        return $next($request);
    }
}