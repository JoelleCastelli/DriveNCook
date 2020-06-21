<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventInvited;
use App\Models\Location;
use App\Models\User;
use App\Traits\EmailTools;
use App\Traits\EnumValue;
use App\Traits\UserTools;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class EventController extends Controller
{
    use EmailTools;

//    use EnumValue;
    use UserTools;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function event_list()
    {
        $event_list = Event::with('user')->with('location')->with('invited')->orderByDesc('date_start')->get()->toArray();
        $event_calendar = [];
        foreach ($event_list as $key => $event) {
            $event_calendar[] = Calendar::event(
                $event['title'],
                true,
                new \DateTime($event['date_start']),
                new \DateTime($event['date_end']),
                $event['id'],
                [
                    'url' => route('corporate.event_view', ['event_id' => $event['id']])
                ]
            );
        }
        $calendar_details = Calendar::addEvents($event_calendar);
//        dd($event_list);
        return view('corporate.events.event_list')
            ->with('calendar_details', $calendar_details)
            ->with('event_list', $event_list);
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
        return view('corporate.events.event_creation');
    }

    public function event_create_type()
    {
        request()->validate([
            'type' => ['required'],
        ]);
        $type = request('type');
        if (!in_array($type, $this->get_enum_column_values('event', 'type'))) {
            abort(404);
        }
        $location_list = Location::all()->toArray();
        $user_list = User::whereIn('role', ['Client', 'Franchisé'])->get()->toArray();

        return view('corporate.events.event_creation')
            ->with('user_list', $user_list)
            ->with('location_list', $location_list)
            ->with('type', $type);
    }

    public function event_create_submit()
    {
        request()->validate([
            'type' => 'required',
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'date_start' => ['required', 'date', 'after_or_equal:today'],
            'date_end' => ['required', 'date', 'after_or_equal:date_start']
        ]);
        $data = request()->except('_token');

        $id = Event::insertGetId([
            'type' => $data['type'],
            'date_start' => $data['date_start'],
            'date_end' => $data['date_end'],
            'title' => $data['title'],
            'description' => $data['description'],
            'location_id' => $data['location_id'],
            'user_id' => $this->get_connected_user()['id'],
        ]);
        if ($data['type'] == 'private') {
            foreach ($data['invited'] as $user_id) {
                $this->event_invite_user($id, $user_id);
            }
        }
        flash("Evenement créé")->success();
        return redirect()->route('corporate.event_list');
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