<?php


use App\Http\Middleware\AuthClient;

Route::get('/client/trucks', [
    'as' => 'truck_location_list',
    'uses' => 'Client\OrderController@truck_location_list'
]);

Route::get('/client/order/{truck_id}', [
    'as' => 'client_order',
    'uses' => 'Client\OrderController@client_order'
]);

Route::group(['middleware' => AuthClient::class], function() {
    Route::post('/client/order', [
        'as' => 'client_order_submit',
        'uses' => 'Client\OrderController@client_order_submit'
    ]);

    Route::get('/client/orders', [
        'as' => 'client_orders',
        'uses' => 'Client\OrderController@client_orders'
    ]);

    Route::get('/client/sales_history', [
        'as' => 'client_sales_history',
        'uses' => 'Client\OrderController@client_sales_history'
    ]);

    Route::get('/client/sale_display/{sale_id}', [
        'as' => 'client_sale_display',
        'uses' => 'Client\OrderController@client_sale_display'
    ]);

    Route::delete('/client/order_cancel/{id}', [
        'as' => 'client_order_cancel',
        'uses' => 'Client\OrderController@client_order_cancel'
    ]);
});