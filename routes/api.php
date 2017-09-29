<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/subscribe/{user}', 'PaymentController@subscribe');
    Route::post('/updateCard/{user}', 'PaymentController@updateCard');
	Route::post('/upgrade/{user}', 'PaymentController@upgrade');
	Route::post('/cancel/{user}', 'PaymentController@cancel');
});
