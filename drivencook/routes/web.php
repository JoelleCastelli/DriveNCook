<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require_once('client/account.php');
require_once('client/auth.php');
require_once('corporate/auth.php');
require_once('corporate/franchisees.php');
require_once('corporate/trucks.php');
require_once('corporate/warehouses.php');
require_once('corporate/dishes.php');
require_once('corporate/country_city.php');
require_once('corporate/client.php');
require_once('franchise/home.php');
require_once('franchise/truck.php');
require_once('franchise/stock.php');

Route::get('/', function () {
    return view('home');
})->name('homepage');

Route::get('/{language}', function ($language) {
    Session::put('locale', $language);
    return back();
})->name('set_locale');

