<?php


Route::get('/client/trucks', [
    'as' => 'truck_location_list',
    'uses' => 'Client\OrderController@truck_location_list'
]);

Route::get('/client/order/{truck_id}', [
    'as' => 'client_order',
    'uses' => 'Client\OrderController@client_order'
]);

Route::post('/client/order', [
    'as' => 'client_order_submit',
    'uses' => 'Client\OrderController@client_order_submit'
]);

Route::get('/client/orders', [
    'as' => 'client_orders',
    'uses' => 'Client\OrderController@client_orders'
]);