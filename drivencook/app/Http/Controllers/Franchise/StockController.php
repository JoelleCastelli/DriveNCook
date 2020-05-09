<?php


namespace App\Http\Controllers\Franchise;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthFranchise;
use App\Traits\EnumValue;
use App\Traits\UserTools;

class StockController extends Controller
{
    use UserTools;
    use EnumValue;

    public function __construct()
    {
        $this->middleware(AuthFranchise::class);
    }

}