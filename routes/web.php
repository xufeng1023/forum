<?php

Auth::routes();

Route::get('/', 'PostController@index');
Route::post('/post', 'PostController@store');
Route::get('/post/new', 'PostController@new');
Route::get('/post/{post}', 'PostController@show');
Route::get('/advertising', 'AdController@new');
