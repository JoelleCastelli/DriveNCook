<?php


use App\Http\Middleware\AuthClient;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/client/trucks', [
    'as' => 'truck_location_list',
    'uses' => 'Client\OrderController@truck_location_list'
]);

Route::get('/client/order/{truck_id}', [
    'as' => 'client_order',
    'uses' => 'Client\OrderController@client_order'
]);

Route::get('/client/qrcode/generate/{truck_id}',[
    'as' => 'generate_franchise_qr',
    'uses' => 'Client\OrderController@qr_code'

]);

Route::group(['middleware' => AuthClient::class], function () {
    Route::post('/client/order', [
        'as' => 'client_order_submit',
        'uses' => 'Client\OrderController@client_order_submit'
    ]);

    Route::get('/client/orders', [
        'as' => 'client_orders',
        'uses' => 'Client\OrderController@client_orders'
    ]);

    Route::get('/client/client_order_charge', [
        'as' => 'client_order_charge',
        'uses' => 'Client\OrderController@client_order_charge'
    ]);

    Route::post('/client/new_order_charge/{order_total_cents}/{payment_type?}', [
        'as' => 'client_new_order_charge',
        'uses' => 'Client\OrderController@charge'
    ]);

    Route::get('/client/sales_history', [
        'as' => 'client_sales_history',
        'uses' => 'Client\OrderController@client_sales_history'
    ]);

    Route::get('/client/sale_invoice/{invoice_id}', [
        'as' => 'stream_client_invoice_pdf',
        'uses' => 'Client\OrderController@stream_client_invoice_pdf'
    ]);

    Route::get('/client/sale_display/{sale_id}', [
        'as' => 'client_sale_display',
        'uses' => 'Client\OrderController@client_sale_display'
    ]);

    Route::delete('/client/order_cancel/{id}', [
        'as' => 'client_order_cancel',
        'uses' => 'Client\OrderController@refund'
    ]);
});