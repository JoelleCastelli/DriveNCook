<?php

Route::get('/franchise/stock', [
    'as' => 'franchise.stock_dashboard',
    'uses' => 'Franchise\StockController@stock_dashboard'
]);

Route::get('/franchise/stock/order/{order_id}', [
    'as' => 'franchise.stock_order_view',
    'uses' => 'Franchise\StockController@stock_order_view'
]);
Route::get('/franchise/stock/new_order', [
    'as' => 'franchise.stock_new_order',
    'uses' => 'Franchise\StockController@stock_order'
]);

Route::post('/franchise/stock/new_order', [
    'as' => 'franchise.stock_order_submit',
    'uses' => 'Franchise\StockController@stock_order_submit'
]);

Route::get('/franchise/stock/new_order/{warehouse_id}', [
    'as' => 'franchise.stock_order_select_warehouse',
    'uses' => 'Franchise\StockController@stock_order_warehouse'
]);

Route::get('/franchise/stock/new_order_validate', [
    'as' => 'franchise.stock_order_validate',
    'uses' => 'Franchise\StockController@stock_order_validate'
]);

Route::delete('/franchise/stock/order_cancel/{order_id}', [
    'as' => 'franchise.stock_order_cancel',
    'uses' => 'Franchise\StockController@stock_order_cancel'
]);

Route::post('/franchise/stock/update', [
    'as' => 'franchise.stock_update_submit',
    'uses' => 'Franchise\StockController@stock_update_submit'
]);

Route::post('/franchise/stock/update_menu_available', [
    'as' => 'franchise.stock_update_menu_available',
    'uses' => 'Franchise\StockController@stock_update_menu_available'
]);

Route::post('/franchise/stock/new_order_charge/{order_total_cents}', [
    'as' => 'franchise.stock_order_charge',
    'uses' => 'Franchise\StockController@charge'
]);