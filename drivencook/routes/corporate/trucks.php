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