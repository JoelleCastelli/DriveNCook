<?php


namespace App\Http\Controllers;


use App\Models\Event;
use App\Models\Truck;

class HomeController extends Controller
{
    public function homepage()
    {
        $trucks = Truck::with('user')->with('location')->where('user_id', "!=", null)->get()->toArray();

        return view('home')->with('trucks', $trucks);
    }

    public function news()
    {
        $news_list = Event::where('type', 'news')->with('location')->orderByDesc('date_start')->get()->toArray();
        $trucks = Truck::with('user')->with('location')->where('user_id', "!=", null)->get()->toArray();
        return view('news')->with('news_list', $news_list)->with('trucks', $trucks);
    }
}