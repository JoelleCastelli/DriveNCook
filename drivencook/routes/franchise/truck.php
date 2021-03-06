<?php

Route::get('/franchise/truck', [
    'as' => 'franchise.truck_view',
    'uses' => 'Franchise\TruckController@truck_view'
]);

Route::get('/franchise/truck_location', [
    'as' => 'franchise.truck_location_update',
    'uses' => 'Franchise\TruckController@update_location'
]);
Route::post('/franchise/truck_location', [
    'as' => 'franchise.truck_location_update_submit',
    'uses' => 'Franchise\TruckController@update_location_submit'
]);
Route::get('/franchise/truck_breakdown', [
    'as' => 'franchise.truck_breakdown_add',
    'uses' => 'Franchise\TruckController@add_breakdown'
]);
Route::get('/franchise/truck_breakdown/{breakdown_id}', [
    'as' => 'franchise.truck_breakdown_update',
    'uses' => 'Franchise\TruckController@update_breakdown'
]);
Route::post('/franchise/truck_breakdown', [
    'as' => 'franchise.truck_breakdown_submit',
    'uses' => 'Franchise\TruckController@breakdown_submit'
]);
Route::get('/franchise/truck_safety_inspection', [
    'as' => 'franchise.truck_safety_inspection_add',
    'uses' => 'Franchise\TruckController@add_safety_inspection'
]);
Route::get('/franchise/truck_safety_inspection/{safety_inspection_id}', [
    'as' => 'franchise.truck_safety_inspection_update',
    'uses' => 'Franchise\TruckController@update_safety_inspection'
]);
Route::post('/franchise/truck_safety_inspection', [
    'as' => 'franchise.truck_safety_inspection_submit',
    'uses' => 'Franchise\TruckController@safety_inspection_submit'
]);


