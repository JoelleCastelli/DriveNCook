<?php


namespace App\Http\Controllers\Franchise;


use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
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
            flash("Connexion réussie")->success();
            return redirect(route('franchise.dashboard'));
        }

        return back()->withInput()->withErrors([
            'email' => 'Vos identifiants sont incorrects.'
        ]);
    }

    public function logout()
    {
        auth()->logout();
        flash("Déconnexion réussie")->success();
        return redirect(route('franchise.login'));
    }

    public function complete_registration()
    {
        $email = request()->session()->get('email_registration', null);
        if ($email == null) {
            abort(404);
        }
        return view('franchise.registration.complete_registration')
            ->with('email', $email)
            ->with('pseudos', $this->get_available_pseudo_list());
    }

    public function complete_registration_submit()
    {
        request()->validate([
            'email' => ['required', 'string', 'email:rfc', 'max:100'],
            'telephone' => ['nullable', 'regex:/^(0|\+[1-9]{2}\s?)[1-9]([-. ]?\d{2}){4}$/u'],
            'driving_licence' => ['required', 'string', 'max:15'],
            'social_security' => ['required', 'string', 'max:15'],
            'pseudo' => ['required', 'integer'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);
        $update_array = request()->except(['_token', 'email', 'password_confirmation', 'pseudo']);
        $update_array['password'] = hash('sha256', $update_array['password']);
        $update_array['email'] = request()->session()->get('email_registration', null);
        $update_array['pseudo_id'] = request('pseudo');
//        dd($update_array);

        User::where('email', $update_array['email'])
            ->update($update_array);

        flash('Vous êtres maintenant prêt ! Connectez vous dès à présent')->success();
        request()->session()->forget('email_registration');
        return redirect(route('franchise.login'));
    }

    public function complete_registration_email()
    {
        request()->validate(['email' => ['required', 'email']]);

        $user = User::where('email', request('email'))->first();
        if (empty($user)) {
            abort(404);
        }
        $user = $user->toArray();
        if ($user['role'] != 'Franchisé') {
            flash("Cet utilisateur n'est pas un franchisé")->error();
            return redirect(route('franchise.login'));
        }
        if (!empty($user['driving_licence'])
            && !empty($user['social_security'])
            && !empty($user['telephone'])
            && !empty($user['pseudo_id'])) {
            flash("Votre compte a déjà été complété, vous pouvez vous connecter")->warning();
            return redirect(route('franchise.login'));
        }

        request()->session()->put('email_registration', request('email'));
        return redirect(route('franchise.complete_registration'));
    }
}