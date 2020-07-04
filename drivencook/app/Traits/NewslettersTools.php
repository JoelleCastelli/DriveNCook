<?php


namespace App\Traits;


use App\Models\User;

trait NewslettersTools
{
    use EmailTools;

    public function sendNewsLettersAllClients(string $message = '')
    {
        $user_list = User::where([['opt_in', 1], ['role', 'Client']])
            ->with('event_invited_30')
            ->withCount('client_orders')->get()->toArray();

        foreach ($user_list as $user) {
            $this->sendNewsLetter($user, $message);
        }
        flash(trans('corporate.newsletter_sent'))->success();
        return redirect()->route('client_list');
    }

    public function sendNewsLettersNewClients(string $message = '')
    {
        $user_list = User::withCount('client_orders')
            ->with('event_invited_30')
            ->where([['opt_in', 1], ['role', 'Client']])
            ->having('client_orders_count', '=', '0')
            ->get()->toArray();

        foreach ($user_list as $user) {
            $this->sendNewsLetter($user, $message);
        }

        flash(trans('corporate.newsletter_sent'))->success();
        return redirect()->route('client_list');

    }

    public function sendNewsLettersFidelityStepClients(string $message = '', int $loyalty_point = 0)
    {
        $user_list = User::where([
            ['opt_in', 1],
            ['loyalty_point', '>=', $loyalty_point],
            ['role', 'Client']
        ])
            ->with('event_invited_30')
            ->withCount('client_orders')
            ->get()->toArray();

        foreach ($user_list as $user) {
            $this->sendNewsLetter($user, $message);
        }

        flash(trans('corporate.newsletter_sent'))->success();
        return redirect()->route('client_list');

    }

}