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
// Corporate - Auth

Route::get('/corporate/login', [
    'as' => 'corporate_login',
    'uses' => 'Corporate\CorporateAuthController@loginForm'
]);
Route::post('/corporate/login', [
    'as' => 'corporate_login',
    'uses' => 'Corporate\CorporateAuthController@processLoginForm'
]);

Route::get('/corporate/logout', [
    'as' => 'corporate_logout',
    'uses' => 'Corporate\CorporateAuthController@logout'
]);

// Corporate - Franchise
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


//Route::post('/test', [
//    'as' => 'test',
//    'uses' => 'Corporate\FranchiseeController@test'
//]);
//
//Route::get('/test/get-by-email/{email}', [
//    'as' => 'test_mail',
//    'uses' => 'Corporate\FranchiseeController@get_franchisee_by_email'
//]);
//

// Corporate - Truck
Route::get('/corporate/truck_list', [
    'as' => 'truck_list',
    'uses' => 'Corporate\TruckController@truck_list'
]);

Route::get('/corporate/truck_creation', [
    'as' => 'truck_creation',
    'uses' => 'Corporate\TruckController@truck_creation'
]);

Route::post('/corporate/truck_creation_submit', [
    'as' => 'truck_creation_submit',
    'uses' => 'Corporate\TruckController@truck_creation_submit'
]);

Route::get('/corporate/truck_update/{id}', [
    'as' => 'truck_update',
    'uses' => 'Corporate\TruckController@truck_update'
]);

Route::post('/corporate/truck_update_submit', [
    'as' => 'truck_update_submit',
    'uses' => 'Corporate\TruckController@truck_update_submit'
]);

Route::delete('/corporate/truck_delete/{id}', [
    'as' => 'truck_delete',
    'uses' => 'Corporate\TruckController@truck_delete'
]);
//

// Corporate - Warehouse
Route::get('/corporate/warehouse_list', [
    'as' => 'warehouse_list',
    'uses' => 'Corporate\WarehouseController@warehouse_list'
]);

Route::get('/corporate/warehouse_creation', [
    'as' => 'warehouse_creation',
    'uses' => 'Corporate\WarehouseController@warehouse_creation'
]);

Route::post('/corporate/warehouse_creation_submit', [
    'as' => 'warehouse_creation_submit',
    'uses' => 'Corporate\WarehouseController@warehouse_creation_submit'
]);
//