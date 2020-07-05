<?php


namespace App\Http\Controllers\Franchise;


use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
use App\Models\Truck;
use App\Models\User;
use App\Traits\UserTools;
use Illuminate\Support\Facades\App;


class AuthController extends Controller
{
    use UserTools;

    public function loginForm()
    {
        return view('franchise.franchise_login');
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
                'role' => "Franchisé"
            ])
            ||
            auth()->attempt([
                'email' => request('email'),
                'password' => request('password'),
                'role' => "Administrateur"
            ]);

        if ($result) {
            flash(trans('auth.connected'))->success();
            return redirect(route('franchise.dashboard'));
        }

        return back()->withInput()->withErrors(['franchisee_login' => trans('auth.failed')]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect(route('homepage'));
    }

    public function complete_registration()
    {
        $email = request()->session()->get('email_registration', null);
        if ($email == null) {
            abort(404);
        }

        $trucks = Truck::with('user')->with('location')->where('user_id', "!=", null)->get()->toArray();

        return view('app')
            ->with('email', $email)
            ->with('trucks', $trucks)
            ->with('pseudos', $this->get_available_pseudo_list());
    }

    public function complete_registration_submit()
    {
        request()->validate([
            'email' => ['required', 'string', 'email:rfc', 'max:100'],
            'telephone' => ['nullable', 'regex:/^(0|\+[1-9]{2}\s?)[1-9]([-. ]?\d{2}){4}$/u'],
            'driving_licence' => ['required', 'string','min:5', 'max:15'],
            'social_security' => ['required', 'string','min:5', 'max:15'],
            'pseudo' => ['required', 'integer'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $update_array = request()->except(['_token', 'email', 'password_confirmation', 'pseudo']);
        $update_array['password'] = hash('sha256', $update_array['password']);
        $update_array['email'] = request()->session()->get('email_registration', null);
        $update_array['pseudo_id'] = request('pseudo');

        User::where('email', $update_array['email'])
            ->update($update_array);

        request()->session()->forget('email_registration');
        return redirect(route('homepage'))->withInput()->withErrors(
            ['franchisee_confirmation_success' => trans('auth.franchisee_confirmation_success')]
        );
    }

    public function complete_registration_email()
    {
        request()->validate(['email' => ['required', 'email']]);

        $user = User::where('email', request('email'))->first();
        if (empty($user)) {
            return back()->withInput()->withErrors(
                ['franchisee_first_login' => trans('auth.no_user_found')]
            );
        }
        $user = $user->toArray();
        if ($user['role'] != 'Franchisé') {
            return back()->withInput()->withErrors(
                ['franchisee_first_login' => trans('auth.no_franchisee_found')]
            );
        }
        if ($this->is_franchisee_valided($user['id'])) {
            return back()->withInput()->withErrors(
                ['franchisee_first_login' => trans('auth.already_validated')]
            );
        }

        request()->session()->put('email_registration', request('email'));
        return redirect(route('franchise.complete_registration'));
    }
}