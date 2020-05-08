<?php


namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
use App\Traits\UserTools;
use Illuminate\Support\Facades\App;


class AccountController extends Controller
{
    use UserTools;

    public function __construct()
    {
        $this->middleware(AuthFranchise::class);
    }


    public function dashboard()
    {
        return view('franchise.franchise_dashboard')
            ->with('franchise', $this->get_connected_user());
    }
}