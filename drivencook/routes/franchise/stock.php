<?php

Route::get('/franchise/stock', [
    'as' => 'franchise.stock_dashboard',
    'uses' => 'Franchise\StockController@stock_dashboard'
]);

Route::get('/franchise/stock/order', [
    'as' => 'franchise.stock_order',
    'uses' => 'Franchise\StockController@stock_order'
]);

Route::get('/franchise/stock/order/{order_id}', [
    'as' => 'franchise.stock_order_view',
    'uses' => 'Franchise\StockController@stock_order_view'
]);

Route::post('/franchise/stock/order', [
    'as' => 'franchise.stock_order_submit',
    'uses' => 'Franchise\StockController@stock_order_submit'
]);

Route::delete('/franchise/stock/order_cancel/{order_id}', [
    'as' => 'franchise.stock_order_cancel',
    'uses' => 'Franchise\StockController@stock_order_cancel'
]);

Route::get('/franchise/stock/order/{warehouse_id}', [
    'as' => 'franchise.stock_order_select_warehouse',
    'uses' => 'Franchise\StockController@stock_order_warehouse'
]);

Route::post('/franchise/stock/update', [
    'as' => 'franchise.stock_update_submit',
    'uses' => 'Franchise\StockController@stock_update_submit'
]);


