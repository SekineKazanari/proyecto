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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    //Book
    Route::get('/books','BookController@index');
    Route::post('/books', 'BookController@store');
    Route::get('/books/{id}', 'BookController@show');
    Route::put('/books', 'BookController@update');
    Route::delete('/books/{book}', 'BookController@destroy');
    //Loan
    Route::get('/loans','LoanController@index');
    Route::put('/loans', 'LoanController@update');
    Route::get('/loans/stats', 'LoanController@show');
    Route::post('/loans', 'LoanController@store');
    Route::delete('/loans/{loan}', 'LoanController@destroy');
    //Categories
    Route::get('/categories', 'CategoryController@index');
    Route::post('/categories','CategoryController@store');
    Route::put('/categories','CategoryController@update');
    Route::delete('/categories/{category}','CategoryController@destroy');
    //User
    Route::get('/users','UserController@index');
    Route::post('/users','UserController@store');
    Route::get('/users/details/{id}','UserController@show');
    Route::put('/users','UserController@update');
    Route::delete('/users/{id}','UserController@destroy');

});
