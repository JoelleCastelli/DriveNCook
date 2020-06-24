<?php


namespace App\Http\Controllers;


use App\Models\Event;

class HomeController extends Controller
{
    public function news()
    {
        $news_list = Event::where('type', 'news')->with('location')->orderByDesc('date_start')->get()->toArray();
        return view('news')->with('news_list', $news_list);
    }
}