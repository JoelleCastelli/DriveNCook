<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventInvited;
use App\Models\User;
use App\Traits\EmailTools;

class EventController extends Controller
{
    use EmailTools;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function event_list()
    {
        $event_list = Event::with('user')->with('location')->with('invited')->orderByDesc('date_start')->get()->toArray();
//        dd($event_list);
        return view('corporate.events.event_list')->with('event_list', $event_list);
    }

    public function event_view($event_id)
    {
        $event = Event::with('user')->with('location')->with('invited')->orderByDesc('date_start')->whereKey($event_id)->first();
        if (empty($event)) {
            abort(404);
        }
        $event = $event->toArray();

        $user_list = [];
        if ($event['type'] == 'private') {
            $invited_id = [];
            foreach ($event['invited'] as $invited)
                $invited_id[] = $invited['user_id'];

            $user_list = User::whereNotIn('id', $invited_id)->get(['id', 'email', 'firstname', 'lastname'])->toArray();
        }
        return view('corporate.events.event_view')
            ->with('user_list', $user_list)
            ->with('event', $event);
    }

    public function event_update($event_id)
    {

    }

    public function event_create()
    {

    }

    public function event_invite_user($event_id, $user_id)
    {
        $user = User::whereKey($user_id)->first();
        if (empty($user->email) || empty(Event::whereKey($event_id)->first())) {
            abort(404);
        }
        if (empty(EventInvited::where(['event_id' => $event_id, 'user_id' => $user_id])->first())) {

            EventInvited::insert([
                'event_id' => $event_id,
                'user_id' => $user_id
            ]);
        }
        $this->sendEventMail($user->email, $event_id);
        flash($user->email . ' invité')->success();

        return redirect()->route('corporate.event_view', ['event_id' => $event_id]);
    }

    public function event_create_type()
    {
        //request post
    }

    public function event_delete($event_id)
    {
        if (!ctype_digit($event_id)) {
            return 'error';
        }
        EventInvited::where('event_id', $event_id)->delete();
        Event::whereKey($event_id)->delete();
        return $event_id;

    }
}