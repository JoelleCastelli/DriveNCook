<?php


namespace App\Traits;


use App\Models\User;
use Illuminate\Support\Facades\Mail;

trait EmailTools
{
    public function sendResetPasswordMail($user_mail, $token)
    {
        $user = User::where("email", $user_mail)->first()->toArray();
        $to_name = $user['firstname'] . ' ' . $user['lastname'];
        $to_email = $user_mail;
        $data = array('name' => $to_name, 'token' => $token);
        Mail::send('mails.reset_password', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Drivencook password reset');
            $message->from('noreply@drivencook.fr');
        });
    }

}