<?php

Route::get('/corporate/event', [
    'as' => 'corporate.event_list',
    'uses' => 'Corporate\EventController@event_list'
]);
Route::get('/corporate/event/create', [
    'as' => 'corporate.event_creation',
    'uses' => 'Corporate\EventController@event_create'
]);

Route::get('/corporate/event/{event_id}', [
    'as' => 'corporate.event_view',
    'uses' => 'Corporate\EventController@event_view'
]);

Route::get('/corporate/event/{event_id}/{user_id}', [
    'as' => 'corporate.event_invite_user',
    'uses' => 'Corporate\EventController@event_invite_user'
]);

Route::get('/corporate/event/update/{event_id}', [
    'as' => 'corporate.event_update',
    'uses' => 'Corporate\EventController@event_update'
]);

Route::delete('/corporate/event_delete/{event_id}', [
    'as' => 'event_delete',
    'uses' => 'Corporate\EventController@event_delete'
]);

