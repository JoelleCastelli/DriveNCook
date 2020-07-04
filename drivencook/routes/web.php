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
require_once('client/orders.php');
require_once('client/event.php');
require_once('corporate/administrator.php');
require_once('corporate/auth.php');
require_once('corporate/franchisees.php');
require_once('corporate/trucks.php');
require_once('corporate/warehouses.php');
require_once('corporate/dishes.php');
require_once('corporate/country_city.php');
require_once('corporate/client.php');
require_once('corporate/event.php');
require_once('corporate/stats.php');
require_once('franchise/home.php');
require_once('franchise/truck.php');
require_once('franchise/stock.php');
require_once('franchise/invoice.php');
require_once('franchise/event.php');
require_once('franchise/revenues_stats.php');
require_once('franchise/client_sales.php');

Route::get('/', [
    'as' => 'homepage',
    'uses' => 'HomeController@homepage'
]);

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/news', [
    'as' => 'news',
    'uses' => 'HomeController@news'
]);

Route::get('/{language}', function ($language) {
    Session::put('locale', $language);
    return back();
})->name('set_locale');

Route::post('/forgot_password/', [
    'as' => 'forgot_password',
    'uses' => 'Auth\ForgotPasswordController@send_email'
]);

Route::get('/reset_password/{token}', [
    'as' => 'reset_password',
    'uses' => 'Auth\ResetPasswordController@reset_password'
]);

Route::post('/reset_password/', [
    'as' => 'reset_password_submit',
    'uses' => 'Auth\ResetPasswordController@reset_password_submit'
]);
