<?php


namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
use App\Traits\TruckTools;
use App\Traits\UserTools;
use Illuminate\Support\Facades\App;


class AccountController extends Controller
{
    use UserTools;
    use TruckTools;

    public function __construct()
    {
        $this->middleware(AuthFranchise::class);
    }


    public function dashboard()
    {
        $truck = $this->get_truck_with_location_only($this->get_franchises_truck($this->get_connected_user()['id'])['id']);
//        var_dump($truck);die;

        return view('franchise.franchise_dashboard')
            ->with('truck', $truck)
            ->with('franchise', $this->get_connected_user());
    }
}