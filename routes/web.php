<?php

use App\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main.index');
});

Route::get('/categories', 'CategoriesController@index')->name('categories');
Route::post('/categories', 'CategoriesController@store')->name('newCategory');
Route::get('/categories/{id}', 'CategoriesController@show')->name('showCategory');
Route::patch('/categories/{id}', 'CategoriesController@update')->name('updateCategory');
Route::delete('/categories/{id}', 'CategoriesController@destroy')->name('destroyCategory');

Route::get('/products', 'ProductsController@index')->name('products.index');
Route::post('/products', 'ProductsController@store')->name('products.store');
Route::get('/products/{id}', 'ProductsController@show')->name('products.show');
Route::patch('/products/{id}', 'ProductsController@update')->name('products.update');
Route::delete('/products/{id}', 'ProductsController@destroy')->name('products.destroy');

Route::get('/employees', 'EmployeesController@index')->name('employees.index');
Route::post('/employees', 'EmployeesController@store')->name('employees.store');
Route::get('/employees/{id}', 'EmployeesController@show')->name('employees.show');
Route::patch('/employees/{id}', 'EmployeesController@update')->name('employees.update');
Route::delete('/employees/{id}', 'EmployeesController@destroy')->name('employees.destroy');

Route::get('/clients', 'ClientsController@index')->name('clients.index');
Route::post('/clients', 'ClientsController@store')->name('clients.store');
Route::get('/clients/{id}', 'ClientsController@show')->name('clients.show');
Route::patch('/clients/{id}', 'ClientsController@update')->name('clients.update');
Route::delete('/clients/{id}', 'ClientsController@destroy')->name('clients.destroy');

Route::get('/users', 'UsersController@index')->name('users.index');
Route::post('/users', 'UsersController@store')->name('users.store');
Route::get('/users/{id}', 'UsersController@show')->name('users.show');
Route::patch('/users/{id}', 'UsersController@update')->name('users.update');
Route::delete('/users/{id}', 'UsersController@destroy')->name('users.destroy');

Route::get('/sales', 'SalesController@index')->name('sales.index');
Route::get('/sales/new', 'SalesController@create')->name('sales.create');
Route::get('/sales/changeMethod', 'SalesController@changeMethod');
Route::get('/sales/view/{id}', 'SalesController@view')->name('sales.view');
Route::post('/sales', 'SalesController@store')->name('sales.store');
Route::get('/sales/{id}', 'SalesController@show')->name('sales.show');
Route::patch('/sales/{id}', 'SalesController@update')->name('sales.update');
Route::patch('/sales/status/{id}', 'SalesController@status')->name('sales.status');
Route::delete('/sales/{id}', 'SalesController@destroy')->name('sales.destroy');

Route::get('/report/employees', 'EmployeesController@generatePDF')->name('employees.pdf');
// Route::get('/report/clients', 'ClientsController@generatePDF')->name('clients.pdf');

// Route::get('/actualizar', 'EmployeesController@updateAll');
// Route::get('/actualizar', 'ClientsController@updateAll');

