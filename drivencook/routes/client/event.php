<?php

Route::get('/client/event', [
    'as' => 'client.event_list',
    'uses' => 'Client\EventController@event_list'
]);

Route::get('/client/event/view/{event_id}', [
    'as' => 'client.event_view',
    'uses' => 'Client\EventController@event_view'
]);
