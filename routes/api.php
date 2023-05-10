<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/category', 'CategoriesController@all');
Route::post('/category', 'CategoriesController@add');
Route::get('/category/{id}', 'CategoriesController@get');
Route::patch('/category/{id}', 'CategoriesController@patch');
Route::delete('/category/{id}', 'CategoriesController@destroy');

Route::get('/product', 'ProductsController@all');
Route::post('/product', 'ProductsController@add');
Route::get('/product/{id}', 'ProductsController@get');
Route::patch('/product/{id}', 'ProductsController@patch');
Route::delete('/product/{id}', 'ProductsController@destroy');

Route::get('/employee', 'EmployeesController@all');
Route::post('/employee', 'EmployeesController@add');
Route::get('/employee/{id}', 'EmployeesController@get');
Route::patch('/employee/{id}', 'EmployeesController@patch');
Route::delete('/employee/{id}', 'EmployeesController@destroy');

Route::get('/client', 'ClientsController@all');
Route::post('/client', 'ClientsController@add');
Route::get('/client/{id}', 'ClientsController@get');
Route::patch('/client/{id}', 'ClientsController@patch');
Route::delete('/client/{id}', 'ClientsController@destroy');

Route::get('/user', 'UsersController@all');
Route::post('/user', 'UsersController@add');
Route::get('/user/{id}', 'UsersController@get');
Route::patch('/user/{id}', 'UsersController@patch');
Route::delete('/user/{id}', 'UsersController@destroy');

Route::get('/sales', 'SalesController@index');
Route::get('/sales/new', 'SalesController@create');
Route::get('/sales/changeMethod', 'SalesController@changeMethod');
Route::get('/sales/view/{id}', 'SalesController@view');
Route::post('/sales', 'SalesController@store');
Route::get('/sales/{id}', 'SalesController@show');
Route::patch('/sales/{id}', 'SalesController@update');
Route::patch('/sales/status/{id}', 'SalesController@status');
Route::delete('/sales/{id}', 'SalesController@destroy');

Route::get('/report/employees', 'EmployeesController@generatePDF');
