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

require_once('corporate/auth.php');
require_once('corporate/franchisees.php');
require_once('corporate/trucks.php');
require_once('corporate/warehouses.php');

Route::get('/', function () {
    return view('welcome');
});

//Route::post('/test', [
//    'as' => 'test',
//    'uses' => 'Corporate\FranchiseeController@test'
//]);