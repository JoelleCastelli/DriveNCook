<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\FranchiseeStock;
use App\Models\User;
use App\Traits\NewslettersTools;
use App\Traits\UserTools;
use Carbon\Carbon;

class ClientController extends Controller
{
    use UserTools;
    use NewslettersTools;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function client_list()
    {
        $client_list = User::where('role', 'Client')->get()->toArray();
        $month_sale_count = Sale::where("date", ">=", Carbon::today()->subDays(30))->count();
        $total_sale_count = Sale::count();

        return view('corporate.client.client_list')
            ->with('client_list', $client_list)
            ->with('total_sale_count', $total_sale_count)
            ->with('month_sale_count', $month_sale_count);
    }

    public function add_client()
    {

    }

    public function add_client_submit()
    {

    }

    public function update_client($client_id)
    {
        $client = User::find($client_id)->toArray();
        return view('corporate.client.client_update')
            ->with('client', $client);
    }

    public function update_client_submit()
    {
        request()->validate([
            'id' => ['required', 'numeric'],
            'lastname' => ['required'],
            'firstname' => ['required'],
            'birthdate' => ['nullable', 'date'],
            'email' => ['required', 'email'],
            'telephone' => ['nullable', 'regex:/^(0|\+[1-9]{2}\s?)[1-9]([-. ]?\d{2}){4}$/u']
        ]);

        User::find(request('id'))->update([
            'lastname' => request('lastname'),
            'firstname' => request('firstname'),
            'birthdate' => request('birthdate'),
            'telephone' => request('telephone'),
            'email' => request('email'),
        ]);

        flash('Utilisateur modifié')->success();
        return redirect()->route('client_update', ['id' => request('id')]);
    }

    public function client_update_password()
    {
        request()->validate([
            'id' => ['required', 'integer'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $this->update_user_password(request('id'), request('password'));
        flash('Mot de passe du client modifié')->success();
        return back();
    }

    public function delete_client($client_id)
    {
        Sale::where("user_client", $client_id)->delete();
        $this->delete_user($client_id);
        return $client_id;
    }

    public function view_client($client_id)
    {
        $client = User::find($client_id)->toArray();
        $client_orders = $this->process_client_sales($client_id);
//        var_dump($client_orders);
//        die;

        return view('corporate.client.client_view')
            ->with('client', $client)
            ->with('client_orders', $client_orders);
    }

    public function process_client_sales($client_id)
    {
//        $sales = Sale::where("user_client", $client_id)
//            ->with('sold_dishes')
//            ->with('user_franchised')
//            ->get()->toArray();
//        for ($i = 0; $i < count($sales); $i++) {
//            $franchisee_id = $sales[$i]['user_franchised']['id'];
//            for ($j = 0; $j < count($sales[$i]['sold_dishes']); $j++) {
//                $price = FranchiseeStock::where([
//                    ['user_id', $franchisee_id],
//                    ['dish_id', $sales[$i]['sold_dishes'][$j]['dish_id']]
//                ])->get(['unit_price'])->first()->toArray()['unit_price'];
//                $sales[$i]['sold_dishes'][$j]['unit_price'] = $price;
//            }
//        }
        //TODO client sales
        return array();
    }

    public function send_newsletter()
    {
        request()->validate([
            'type' => ['required'],
            'loyalty_point' => ['nullable', 'integer', 'min:0'],
            'news_message' => ['nullable', 'string', 'max:255']
        ]);
        $param = request()->except('_token');
        if (empty($param['news_message'])) {
            $param['news_message'] = '';
        }
        switch ($param['type']) {
            case 'all':
                return $this->sendNewsLettersAllClients($param['news_message']);
                break;
            case 'new':
                return $this->sendNewsLettersNewClients($param['news_message']);
                break;
            case 'loyalty':
                return $this->sendNewsLettersFidelityStepClients($param['news_message'], $param['loyalty_point']);
                break;
            default:
                flash(trans('corporate.newsletter_type_error'))->success();
                return back();
        }
    }

    public function send_newsletter_unique()
    {
        request()->validate([
            'user_id' => ['required', 'integer'],
            'news_message' => ['nullable', 'string', 'max:255']
        ]);
        $param = request()->except('_token');

        $user = User::whereKey($param['user_id'])
            ->with('event_invited_30')
            ->withCount('client_orders')->first();

        if (empty($user)) {
            abort((404));
        }
        $user = $user->toArray();

        $this->sendNewsLetter($user, $param['news_message']);
        flash(trans('corporate.newsletter_sent'))->success();
        return back();

    }

}