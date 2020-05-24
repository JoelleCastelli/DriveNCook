<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthClient;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthClient::class);
    }
}