<?php

Route::get('/franchise/invoices', [
    'as' => 'franchise.invoices_list',
    'uses' => 'Franchise\InvoiceController@invoices_list'
]);
