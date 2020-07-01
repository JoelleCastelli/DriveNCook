<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\FranchiseeStock;
use App\Models\User;
use App\Traits\UserTools;
use Carbon\Carbon;

class ClientController extends Controller
{
    use UserTools;

    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function client_list()
    {
        $client_list = User::where('role', 'Client')->get()->toArray();
        $sale_count = Sale::where("date", ">=", Carbon::today()->subDays(30))->count();

        return view('corporate.client.client_list')
            ->with('client_list', $client_list)
            ->with('sale_count', $sale_count);
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

}