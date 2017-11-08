<?php

//Auth::routes();

Route::get('/', 'BlogController@index');
Route::post('/post', 'BlogController@store');
Route::get('/post/new', 'BlogController@new');
Route::get('/blog/{blog}', 'BlogController@show');
//Route::get('/advertising', 'AdController@new');

//Route::post('stripe/success', 'WebhookController@handleInvoicePaymentSucceeded');

Route::post(
    'stripe/webhook',
    'WebhookController@handleWebhook'
);
