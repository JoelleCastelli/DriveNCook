<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\EmailTools;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use EmailTools;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function send_email()
    {
        $email = request()->get('email');
        if (empty($email)) {
            abort(404);
        }
        $token = '';
        $user = User::where('email', $email)->first();
        if (empty($user)) {
            abort(404);
        }
        try {
            $token = substr(str_shuffle(bin2hex(random_bytes(50))), 0, 50);
        } catch (\Exception $e) {
            abort(500);
        }
        $user->update(['password_token' => $token]);
        $this->sendResetPasswordMail($email, $token);

        flash('Un email vous a été envoyé');
        return redirect(route('homepage'));
    }
}