<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Truck;
use App\Traits\UserTools;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class EventController extends Controller
{
    use UserTools;

    private $trucks;
    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthClient');
        $this->trucks = Truck::with('user')->with('location')->where([
            ['functional', true],
            ['user_id', "!=", null]
        ])->get()->toArray();
    }

    public function event_list()
    {
        $event_list_public = Event::with('location')
            ->whereIn('type', ['public', 'news'])
            ->orderByDesc('date_start')->get()->toArray();

        $event_list_invited = Event::with('location')
            ->where('type', 'private')
            ->join('event_invited', function ($join) {
                $join->on('event.id', '=', 'event_invited.event_id')
                    ->where('event_invited.user_id', '=', $this->get_connected_user()['id']);
            })->orderByDesc('date_start')->get()->toArray();

        $event_calendar = [];

        foreach ($event_list_public as $event) {
            $event_calendar[] = Calendar::event(
                $event['title'],
                true,
                new \DateTime($event['date_start']),
                new \DateTime($event['date_end']),
                $event['id'],
                [
                    'url' => route('client.event_view', ['event_id' => $event['id']]),
                    'color' => $event['type'] == 'public' ? '#378006' : '#06a2e9'
                ]
            );
        }
        foreach ($event_list_invited as $event) {
            $event_calendar[] = Calendar::event(
                $event['title'],
                true,
                new \DateTime($event['date_start']),
                new \DateTime($event['date_end']),
                $event['id'],
                [
                    'url' => route('client.event_view', ['event_id' => $event['id']]),
                    'color' => '#e90606'
                ]
            );
        }

        $calendar_details = Calendar::addEvents($event_calendar);
        return view('client.events.event_list')
            ->with('calendar_details', $calendar_details)
            ->with('trucks', $this->trucks)
            ->with('event_list', array_merge($event_list_public, $event_list_invited));
    }

    public function event_view($event_id)
    {
        $event = Event::with('user')->with('invited')
            ->with('location')->whereKey($event_id)->first();

        if (empty($event)) {
            abort(404);
        }
        $event = $event->toArray();

        if ($event['type'] == 'private') {
            $invited_id = [];
            foreach ($event['invited'] as $invited) {
                $invited_id[] = $invited['user_id'];
            }
            if (!in_array($this->get_connected_user()['id'], $invited_id)) {
                abort(403);
            }
        }
        return view('client.events.event_view')
            ->with('event', $event);
    }

}