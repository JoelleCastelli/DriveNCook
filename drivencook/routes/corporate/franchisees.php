<?php

Route::get('/corporate/franchisee_obligation', [
    'as' => 'franchisee_obligation_update',
    'uses' => 'Corporate\FranchiseeController@update_franchise_obligation'
]);

Route::post('/corporate/franchisee_obligation/submit', [
    'as' => 'franchisee_obligation_update_submit',
    'uses' => 'Corporate\FranchiseeController@update_franchise_obligation_submit'
]);

Route::get('/corporate/franchisee_list', [
    'as' => 'franchisee_list',
    'uses' => 'Corporate\FranchiseeController@franchisee_list'
]);

Route::get('/corporate/franchisee_view/{id}', [
    'as' => 'franchisee_view',
    'uses' => 'Corporate\FranchiseeController@franchisee_view'
]);

Route::get('/corporate/franchisee_creation', [
    'as' => 'franchisee_creation',
    'uses' => 'Corporate\FranchiseeController@franchisee_creation'
]);

Route::post('/corporate/franchisee_creation_submit', [
    'as' => 'franchisee_creation_submit',
    'uses' => 'Corporate\FranchiseeController@franchisee_creation_submit'
]);

Route::get('/corporate/franchisee_update/{id}', [
    'as' => 'franchisee_update',
    'uses' => 'Corporate\FranchiseeController@franchisee_update'
]);

Route::post('/corporate/franchisee_update_submit', [
    'as' => 'franchisee_update_submit',
    'uses' => 'Corporate\FranchiseeController@franchisee_update_submit'
]);

Route::post('/corporate/franchisee_update/password', [
    'as' => 'franchisee_update_password',
    'uses' => 'Corporate\FranchiseeController@franchise_update_password'
]);

Route::delete('/corporate/franchisee_delete/{id}', [
    'as' => 'franchisee_delete',
    'uses' => 'Corporate\FranchiseeController@delete_franchise'
]);

Route::get('/corporate/franchisee_pseudo', [
    'as' => 'franchisee_pseudo',
    'uses' => 'Corporate\FranchiseeController@pseudo_list'
]);

Route::post('/corporate/franchisee_pseudo_submit', [
    'as' => 'franchisee_pseudo_submit',
    'uses' => 'Corporate\FranchiseeController@pseudo_submit'
]);

Route::delete('/corporate/franchisee_pseudo_delete/{id}', [
    'as' => 'franchisee_pseudo_delete',
    'uses' => 'Corporate\FranchiseeController@pseudo_delete'
]);

Route::delete('/corporate/unset_franchisee_truck/{id}', [
    'as' => 'unset_franchisee_truck',
    'uses' => 'Corporate\FranchiseeController@unset_franchise_truck'
]);

Route::get('/corporate/franchisee_invoice_pdf/{id}', [
    'as' => 'franchisee_invoice_pdf',
    'uses' => 'Corporate\FranchiseeController@franchisee_invoice_pdf'
]);

Route::post('/corporate/franchisee_sales_history_pdf', [
    'as' => 'franchisee_sales_history_pdf',
    'uses' => 'Corporate\FranchiseeController@franchisee_sales_history_pdf'
]);