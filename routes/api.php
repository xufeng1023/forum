<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/subscribe/{user}', 'PaymentController@subscribe');
    Route::post('/resubscribe/{user}', 'PaymentController@resubscribe');
    Route::post('/updateCard/{user}', 'PaymentController@updateCard');
	Route::post('/changePlan/{user}', 'PaymentController@changePlan');
	Route::post('/cancel/{user}', 'PaymentController@cancel');
	Route::post('/resume/{user}', 'PaymentController@resume');
	Route::post('/token', 'PaymentController@getToken');
	Route::post('/ppv/{user}', 'PaymentController@ppv');
	Route::get('/invoices/{user}', 'PaymentController@invoices');
	Route::get('/invoice/{user}', 'PaymentController@invoice');
});
