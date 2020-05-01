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