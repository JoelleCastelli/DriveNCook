<?php

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

Route::delete('/corporate/unset_franchisee_truck/{id}', [
    'as' => 'unset_franchisee_truck',
    'uses' => 'Corporate\TruckController@unset_franchise_truck'
]);

Route::post('/corporate/set_franchisee_truck/', [
    'as' => 'set_franchisee_truck',
    'uses' => 'Corporate\TruckController@set_franchise_truck'
]);


Route::get('/corporate/truck_view/{id}', [
    'as' => 'truck_view',
    'uses' => 'Corporate\TruckController@truck_view'
]);

Route::get('/corporate/truck_unassigned_franchisee_list', [
    'as' => 'truck_unassigned_franchisee',
    'uses' => 'Corporate\TruckController@get_unassigned_truck_franchisees'
]);

Route::get('/corporate/add_breakdown/{truckId}', [
    'as' => 'add_breakdown',
    'uses' => 'Corporate\TruckController@add_breakdown'
]);

Route::get('/corporate/update_breakdown/{truckId}/{breakdownId}', [
    'as' => 'update_breakdown',
    'uses' => 'Corporate\TruckController@update_breakdown'
]);

Route::post('/corporate/update_breakdown', [
    'as' => 'breakdown_submit',
    'uses' => 'Corporate\TruckController@breakdown_submit',
]);

Route::delete('/corporate/delete_breakdown/{id}', [
    'uses' => 'Corporate\TruckController@delete_breakdown',
    'as' => 'delete_breakdown'
]);


Route::get('/corporate/add_safety_inspection/{truckId}', [
    'as' => 'add_safety_inspection',
    'uses' => 'Corporate\TruckController@add_safety_inspection'
]);

Route::get('/corporate/update_safety_inspection/{truckId}/{safetyInspectionId}', [
    'as' => 'update_safety_inspection',
    'uses' => 'Corporate\TruckController@update_safety_inspection'
]);

Route::post('/corporate/update_safety_inspection', [
    'as' => 'safety_inspection_submit',
    'uses' => 'Corporate\TruckController@safety_inspection_submit',
]);

Route::delete('/corporate/delete_safety_inspection/{id}', [
    'uses' => 'Corporate\TruckController@delete_safety_inspection',
    'as' => 'delete_safety_inspection'
]);