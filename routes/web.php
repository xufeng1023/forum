<?php

//Auth::routes();

//Route::get('/', 'BlogController@index');
Route::get('/', 'ConvertController@index');
Route::post('/convert', 'ConvertController@convert');
Route::post('/post', 'BlogController@store');
Route::get('/post/new', 'BlogController@new');
Route::get('/blog/{blog}', 'BlogController@show');
//Route::get('/advertising', 'AdController@new');

Route::post(
    'stripe/webhook',
    'WebhookController@handleWebhook'
);
