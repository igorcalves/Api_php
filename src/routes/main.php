<?php

use App\Http\Route;

Route::get('/', 'HomeController@index');
Route::get('/getUsers', 'UserController@getUsers');
Route::get('/getUserById', 'UserController@getUserById');
Route::post('/createUser', 'UserController@createUser');
Route::put('/updateUser', 'UserController@updateUser');
Route::delete('/deleteUser', 'UserController@deleteUser');

Route::get('/getTodosByUserId', 'TodoController@getTodos');


