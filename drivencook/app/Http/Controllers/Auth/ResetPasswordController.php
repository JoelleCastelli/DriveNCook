<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset_password($token)
    {
        $user = User::where('password_token', $token)->first();
        if (empty($user)) {
            abort(404);
        }

        $trucks = Truck::with('user')->with('location')->where([
            ['functional', true],
            ['user_id', "!=", null]
        ])->get()->toArray();


        session()->put('email', $user->email);

        return view('auth.reset_password')->with('email', $user->email)->with('trucks', $trucks);
    }

    public function reset_password_submit()
    {
        $email = session()->get('email');
        session()->forget('email');
        if (empty($email)) {
            abort(403);
        }

        request()->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $new_hashed_password = hash('sha256', request()->get('password'));

        User::where('email', $email)->update([
            'password' => $new_hashed_password,
            'password_token' => null
        ]);
        flash(trans('auth.password_updated'))->success();
        return redirect()->route('homepage');
    }

}
