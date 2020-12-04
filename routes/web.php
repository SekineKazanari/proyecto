<?php

use Illuminate\Support\Facades\Route;

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

	Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
	    return view('dashboard');
	})->name('dashboard');


	Route::get('/', function () {
	    return view('welcome');
	});

	Route::group(['middleware' => ['auth']],function(){

	//BOOKS
	Route::get('/books', 'BookController@index');

	Route::post('/books', 'BookController@store');

	Route::put('/books', 'BookController@update');

	Route::delete('/books/{book}', 'BookController@destroy');

	//CATEGORIES
	Route::get('/categories','CategoryController@index');

	Route::post('/categories','CategoryController@store');

	Route::put('/categories','CategoryController@update');

	Route::delete('/categories/{category}','CategoryController@destroy');

	//LOANS
	Route::get('/loans','LoanController@index');

	Route::post('/loans','LoanController@store');

	Route::put('/loans','LoanController@update');

	Route::delete('/loans/{loan}','LoanController@destroy');

	//USERS
	Route::get('/users','UserController@index');

	Route::post('/users','LoanController@store');

	Route::put('/users','UserController@update');

	Route::delete('/users/{user}','UserController@destroy');
});
