<?php


Route::get('/franchise/client_sales', [
    'as' => 'franchise.client_sales',
    'uses' => 'Franchise\SaleController@dashboard'
]);

Route::get('/franchise/client_sales/view/{sale_id}', [
    'as' => 'franchise.view_client_sale',
    'uses' => 'Franchise\SaleController@view_client_sale'
]);

Route::post('/franchise/client_sales/update_status', [
    'as' => 'franchise.update_client_sale_status',
    'uses' => 'Franchise\SaleController@update_client_sale_status'
]);
