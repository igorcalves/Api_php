<?php

use App\Http\Route;

Route::get('/', 'HomeController@index');
Route::get('/getUsers', 'UserController@getUsers');


