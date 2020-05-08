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
