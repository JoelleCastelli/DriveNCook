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

Route::get('/', function () {
    return view('welcome');
});

// Franchisee
Route::get('/corporate/franchisee_list', [
    'as' => 'franchisee_list',
    'uses' => 'Corporate\FranchiseeController@franchisee_list'
]);

Route::get('/corporate/franchisee_creation', [
    'as' => 'franchisee_creation',
    'uses' => 'Corporate\FranchiseeController@franchisee_creation'
]);

Route::post('/corporate/franchisee_creation_submit', [
    'as' => 'franchisee_creation_submit',
    'uses' => 'Corporate\FranchiseeController@franchisee_creation_submit'
]);

Route::post('/test', [
    'as' => 'test',
    'uses' => 'Corporate\FranchiseeController@test'
]);

Route::get('/test/get-by-email/{email}', [
    'as' => 'test_mail',
    'uses' => 'Corporate\FranchiseeController@get_franchisee_by_email'
]);
//

// Truck
Route::get('/corporate/truck_creation', [
    'as' => 'truck_creation',
    'uses' => 'Corporate\TruckController@truck_creation'
]);

Route::post('/corporate/truck_creation_submit', [
    'as' => 'truck_creation_submit',
    'uses' => 'Corporate\TruckController@truck_creation_submit'
]);
//