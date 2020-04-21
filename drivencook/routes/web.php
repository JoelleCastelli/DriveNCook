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

Route::get('/corporate', [
    'as' => 'corporate_dashboard',
    'uses' => 'Corporate\AccountController@dashboard'
]);

Route::get('/corporate/franchisee_list', [
    'as' => 'franchisee_list',
    'uses' => 'Corporate\FranchiseeController@franchisee_list'
]);

Route::get('/corporate/franchisee_view/{id}', [
    'as' => 'franchisee_view',
    'uses' => 'Corporate\FranchiseeController@franchisee_view'
]);

Route::get('/corporate/franchisee_creation', [
    'as' => 'franchisee_creation',
    'uses' => 'Corporate\FranchiseeController@franchisee_creation'
]);

Route::get('/corporate/franchisee_obligation', [
    'as' => 'franchisee_obligation_update',
    'uses' => 'Corporate\FranchiseeController@update_franchise_obligation'
]);
Route::post('/corporate/franchisee_obligation/submit', [
    'as' => 'franchisee_obligation_update_submit',
    'uses' => 'Corporate\FranchiseeController@update_franchise_obligation_submit'
]);

Route::post('/corporate/franchisee_creation_submit', [
    'as' => 'franchisee_creation_submit',
    'uses' => 'Corporate\FranchiseeController@franchisee_creation_submit'
]);

Route::get('/corporate/franchisee_update/{id}', [
    'as' => 'franchisee_update',
    'uses' => 'Corporate\FranchiseeController@franchisee_update'
]);

Route::post('/corporate/franchisee_update_submit', [
    'as' => 'franchisee_update_submit',
    'uses' => 'Corporate\FranchiseeController@franchisee_update_submit'
]);

Route::delete('/corporate/franchisee_delete/{id}', [
    'as' => 'franchisee_delete',
    'uses' => 'Corporate\FranchiseeController@delete_franchise'
]);

Route::get('/corporate/franchisee_pseudo', [
    'as' => 'franchisee_pseudo',
    'uses' => 'Corporate\FranchiseeController@pseudo_list'
]);

Route::post('/corporate/franchisee_pseudo_submit', [
    'as' => 'franchisee_pseudo_submit',
    'uses' => 'Corporate\FranchiseeController@pseudo_submit'
]);


Route::delete('/corporate/franchisee_pseudo_delete/{id}', [
    'as' => 'franchisee_pseudo_delete',
    'uses' => 'Corporate\FranchiseeController@pseudo_delete'
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