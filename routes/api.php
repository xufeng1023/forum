<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/subscribe/{user}', 'PaymentController@subscribe');
    Route::post('/updateCard/{user}', 'PaymentController@updateCard');
	Route::post('/changePlan/{user}', 'PaymentController@changePlan');
	Route::post('/cancel/{user}', 'PaymentController@cancel');
	Route::post('/token', 'PaymentController@getToken');
});
