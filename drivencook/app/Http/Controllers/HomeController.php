<?php


namespace App\Http\Controllers;


use App\Models\Event;
use App\Models\Truck;
use App\Traits\EmailTools;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use EmailTools;

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
    
    public function contact_form_submit(Request $request)
    {
        $parameters = $request->except(['_token']);
        $errors_list = [];

        if (!empty($parameters['name'])
            && !empty($parameters['email'])
            && !empty($parameters['message'])) {

            //$order['order'] = get_object_vars(json_decode($order['order']));

            $this->sendContactForm($parameters);

            $response_array = [
                'status' => 'success',
            ];
        } else {
            $errors_list[] = trans('client/order.missing_post_data');

            $response_array = [
                'status' => 'error',
                'errorList' => $errors_list
            ];
        }

        echo json_encode($response_array);
    }
    
    public function about()
    {
        $trucks = Truck::with('user')->with('location')->where('user_id', "!=", null)->get()->toArray();

        return view('about')->with('trucks', $trucks);
    }
}