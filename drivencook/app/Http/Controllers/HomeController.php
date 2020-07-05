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
        $trucks = Truck::with('user')->with('location')->where([
            ['functional', true],
            ['user_id', "!=", null]
        ])->get()->toArray();

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

        if(!empty($parameters['g-recaptcha-response'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $g_recaptcha_response = $parameters['g-recaptcha-response'];
            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='
                . env('CAPTCHA_SECRET_KEY')
                . '&response='
                . $g_recaptcha_response
                . '&remoteip='
                . $ip);
            $responseKeys = json_decode($response, true);

            if (intval($responseKeys["success"]) !== 1) {
                $response_array = [
                    'status' => 'error_captcha',
                ];
            } else {
                if (!empty($parameters['name'])
                    && !empty($parameters['email'])
                    && !empty($parameters['message'])
                    && strlen($parameters['name']) < 51
                    && strlen($parameters['email']) < 201
                    && strlen($parameters['message']) < 10001) {

                    $this->sendContactForm($parameters);

                    $response_array = [
                        'status' => 'success',
                    ];
                } else {
                    $response_array = [
                        'status' => 'error_data',
                    ];
                }
            }
        } else {
            $response_array = [
                'status' => 'error_captcha_data',
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