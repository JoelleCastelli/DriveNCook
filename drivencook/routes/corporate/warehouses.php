<?php

Route::get('/corporate/warehouse_list', [
    'as' => 'warehouse_list',
    'uses' => 'Corporate\WarehouseController@warehouse_list'
]);

Route::get('/corporate/warehouse_creation', [
    'as' => 'warehouse_creation',
    'uses' => 'Corporate\WarehouseController@warehouse_creation'
]);

Route::post('/corporate/warehouse_creation_submit', [
    'as' => 'warehouse_creation_submit',
    'uses' => 'Corporate\WarehouseController@warehouse_creation_submit'
]);

Route::get('/corporate/warehouse_update/{id}', [
    'as' => 'warehouse_update',
    'uses' => 'Corporate\WarehouseController@warehouse_update'
]);

Route::post('/corporate/warehouse_update_submit', [
    'as' => 'warehouse_update_submit',
    'uses' => 'Corporate\WarehouseController@warehouse_update_submit'
]);

Route::delete('/corporate/warehouse_delete/{id}', [
    'as' => 'warehouse_delete',
    'uses' => 'Corporate\WarehouseController@warehouse_delete'
]);

Route::get('/corporate/warehouse_view/{id}', [
    'as' => 'warehouse_view',
    'uses' => 'Corporate\WarehouseController@warehouse_view'
]);

Route::get('/corporate/warehouse_dishes/{id}', [
    'as' => 'warehouse_dishes',
    'uses' => 'Corporate\WarehouseController@warehouse_dishes'
]);

Route::get('/corporate/warehouse_order/{warehouse_id}/{id}', [
    'as' => 'warehouse_order',
    'uses' => 'Corporate\WarehouseController@warehouse_order'
]);

Route::post('/corporate/warehouse_order_update_product_qty_sent', [
    'as' => 'warehouse_order_update_product_qty_sent',
    'uses' => 'Corporate\WarehouseController@warehouse_order_update_product_qty_sent'
]);

Route::post('/corporate/warehouse_stock_update_submit', [
    'as' => 'warehouse_stock_update_submit',
    'uses' => 'Corporate\WarehouseController@warehouse_stock_update_submit'
]);

Route::post('/corporate/warehouse_stock_creation_submit', [
    'as' => 'warehouse_stock_creation_submit',
    'uses' => 'Corporate\WarehouseController@warehouse_stock_creation_submit'
]);

Route::delete('/corporate/warehouse_stock_delete/{dishId}/{warehouseId}', [
    'as' => 'warehouse_stock_delete',
    'uses' => 'Corporate\WarehouseController@warehouse_stock_delete'
]);