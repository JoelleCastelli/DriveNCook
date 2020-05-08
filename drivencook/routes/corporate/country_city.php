<?php

Route::get('/corporate/country', [
    'as' => 'country_list',
    'uses' => 'Corporate\CityController@country_list'
]);


Route::post('/corporate/country/submit', [
    'as' => 'country_submit',
    'uses' => 'Corporate\CityController@country_submit'
]);

Route::delete('/corporate/country/delete/{id}', [
    'as' => 'country_delete',
    'uses' => 'Corporate\CityController@country_delete'
]);

Route::get('/corporate/city/{country_id}', [
    'as' => 'city_list',
    'uses' => 'Corporate\CityController@city_list'
]);

Route::post('/corporate/city/submit', [
    'as' => 'city_submit',
    'uses' => 'Corporate\CityController@city_submit'
]);

Route::delete('/corporate/city/delete/{id}', [
    'as' => 'city_delete',
    'uses' => 'Corporate\CityController@city_delete'
]);

Route::get('/corporate/location', [
    'as' => 'location_list',
    'uses' => 'Corporate\CityController@location_list'
]);

Route::post('/corporate/location/submit', [
    'as' => 'location_submit',
    'uses' => 'Corporate\CityController@location_submit'
]);

Route::delete('/corporate/location/delete/{id}', [
    'as' => 'location_delete',
    'uses' => 'Corporate\CityController@location_delete'
]);