<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/subscribe/{user}', 'PaymentController@subscribe');
	Route::post('/upgrade', 'PaymentController@upgrade');
	Route::post('/cancel', 'PaymentController@cancel');
});
