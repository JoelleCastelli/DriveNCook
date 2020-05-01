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

Route::delete('/corporate/unset_franchisee_truck/{id}', [
    'as' => 'unset_franchisee_truck',
    'uses' => 'Corporate\TruckController@unset_franchise_truck'
]);

//Route::post('/test', [
//    'as' => 'test',
//    'uses' => 'Corporate\FranchiseeController@test'
//]);
Route::get('/corporate/truck_view/{id}', [
    'as' => 'truck_view',
    'uses' => 'Corporate\TruckController@truck_view'
]);

Route::get('/corporate/truck_unassigned_franchisee_list', [
    'as' => 'truck_unassigned_franchisee',
]);
    'uses' => 'Corporate\TruckController@get_unassigned_truck_franchisees'

Route::get('/corporate/add_breakdown/{truckId}', [
    'as' => 'add_breakdown',
    'uses' => 'Corporate\TruckController@add_breakdown'
]);

Route::get('/corporate/update_breakdown/{truckId}/{breakdownId}', [
    'as' => 'update_breakdown',
    'uses' => 'Corporate\TruckController@update_breakdown'
]);

Route::post('/corporate/update_breakdown', [
    'uses' => 'Corporate\TruckController@breakdown_submit'
    'as' => 'breakdown_submit',
]);

    'as' => 'delete_breakdown',
Route::delete('/corporate/delete_breakdown/{id}', [
    'uses' => 'Corporate\TruckController@delete_breakdown'

]);