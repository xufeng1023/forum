<?php

Route::post('/subscribe', 'PaymentController@subscribe');
Route::post('/updateCard', 'PaymentController@updateCard');
Route::post('/changePlan', 'PaymentController@changePlan');
Route::post('/cancel', 'PaymentController@cancel');
Route::post('/resume', 'PaymentController@resume');
Route::post('/token', 'PaymentController@getToken');
Route::post('/ppv/{post}', 'PaymentController@ppv');
Route::get('/invoices', 'PaymentController@invoices');
Route::get('/invoice', 'PaymentController@invoice');
