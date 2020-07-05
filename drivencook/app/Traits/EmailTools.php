<?php


namespace App\Traits;


use App\Models\Event;
use App\Models\FidelityStep;
use App\Models\User;
use DateTime;
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

    public function sendInvoiceMail($user, $invoice)
    {
        $to_name = $user['firstname'] . ' ' . $user['lastname'];
        $to_email = $user['email'];
        $data = array('user' => $user, 'invoice' => $invoice);
        Mail::send('mails.invoice', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Drivencook invoice');
            $message->from('noreply@drivencook.fr');
        });
    }

    public function sendNewAccountMail($user_mail, $token)
    {
        $user = User::where("email", $user_mail)->first()->toArray();
        $to_name = $user['firstname'] . ' ' . $user['lastname'];
        $to_email = $user_mail;
        $data = array('name' => $to_name, 'token' => $token, 'role' => $user['role']);
        Mail::send('mails.new_user', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Drivencook new account created');
            $message->from('noreply@drivencook.fr');
        });
    }

    public function sendEventMail($user_mail, $event_id)
    {
        $user = User::where("email", $user_mail)->first()->toArray();
        $event = Event::with('user')->with('location')->orderByDesc('date_start')->whereKey($event_id)->first()->toArray();
        $to_name = $user['firstname'] . ' ' . $user['lastname'];
        $data = array(
            'name' => $to_name,
            'title' => $event['title'],
            'begin' => DateTime::createFromFormat('Y-m-d', $event['date_start'])->format('d/m/Y'),
            'end' => DateTime::createFromFormat('Y-m-d', $event['date_end'])->format('d/m/Y'),
            'address' => empty($event['location']) ? 'No address' : $event['location']['address'] . ' - ' . $event['location']['city'] . ' (' . $event['location']['name'] . ')',
            'description' => $event['description']
        );
        Mail::send('mails.event_invite', $data, function ($message) use ($to_name, $user_mail) {
            $message->to($user_mail, $to_name)
                ->subject('Drivencook event');
            $message->from('noreply@drivencook.fr');
        });
    }

    public function sendNewsLetter($user, string $newsMessage)
    {
        $fidelity_step = FidelityStep::where('step', '<=', $user['loyalty_point'])->orderBy('step', 'desc')->first();
        $fidelity = null;
        if (!empty($fidelity_step)) {
            $fidelity = $fidelity_step->reduction;
        }

        $to_name = $user['firstname'] . ' ' . $user['lastname'];
        $to_email = $user['email'];
        $data = array('user' => $user, 'fidelity' => $fidelity, 'newsMessage' => $newsMessage);

        Mail::send('mails.news_letter', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Drivencook newsletter');
            $message->from('noreply@drivencook.fr');
        });

    }

    public function sendContactForm($parameters)
    {
        $corp_mail = 'contact@drivencook.fr';
        $data = ['user' => $parameters];
        Mail::send('mails.contact_form', $data, function ($message) use ($corp_mail) {
            $message->to($corp_mail)
                ->subject('Contact form');
            $message->from('noreply@drivencook.fr');
        });
    }
}