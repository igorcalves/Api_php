<?php

use App\Http\Route;

Route::get('/', 'HomeController@index');

Route::get('/getUsers', 'UserController@getUsers');
Route::get('/getUserById', 'UserController@getUserById');
Route::post('/createUser', 'UserController@createUser');
Route::put('/updateUser', 'UserController@updateUser');
Route::delete('/deleteUser', 'UserController@deleteUser');

Route::get('/getTodosByUserId', 'TodoController@getTodos');
Route::post('/createTodo', 'TodoController@createTodo');
Route::put('/updateTodo', 'TodoController@updateTodo');
Route::delete('/deleteTodo', 'TodoController@deleteTodo');

Route::post('/createAccount', 'AccountController@createAccount');
Route::get('/getAccountByUserId', 'AccountController@getAccountByUserId');
Route::get('/getAllAccounts', 'AccountController@getAllAccounts');
Route::put('/updateAccount', 'AccountController@updateAccount');
Route::delete('/deleteAccount', 'AccountController@deleteAccount');
// Route::get('/getAccountById', 'AccountController@getAccountById');

