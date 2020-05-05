<?php


namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\User;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('App\Http\Middleware\AuthCorporate');
    }

    public function client_list()
    {
        $client_list = User::where('role', 'Client')->get()->toArray();
        return view('corporate.client.client_list')
            ->with('client_list', $client_list);
    }

    public function add_client()
    {

    }

    public function add_client_submit()
    {

    }

    public function update_client()
    {

    }

    public function update_client_submit()
    {

    }

    public function delete_client($client_id)
    {

    }

    public function view_client($client_id)
    {

    }

}