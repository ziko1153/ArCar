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

Route::get('/', 'DashboardController@index');
Route::get('logout', function () {

    return redirect('login');
});

//// Car Hire Route Handler
Route::get('/car/hire', 'HireController@index')->name('car.show');
Route::post('/car/hire/ajax', 'HireController@index')->name('car.showajax');
Route::get('/car/hire/create', 'HireController@create')->name('car.create')->middleware('auth');
Route::post('/car/hire', 'HireController@store');
Route::post('/car/update', 'HireController@update')->name('car.update');
Route::post('/car/destroy', 'HireController@destroy')->name('car.delete');
Route::get('/car/hire/{id}/edit', 'HireController@edit')->name('car.edit');

///// Customer Route Handler
Route::get('/customer', 'CustomerController@index');

Route::get('/car/sale', function () {
    return view('pages.car.sale');
})->name('car.sale');
Auth::routes();