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
Route::post('/customer/show', 'CustomerController@index')->name('customer.showajax');
Route::post('/customer/add', 'CustomerController@store')->name('customer.store');
Route::post('/customer/update', 'CustomerController@update')->name('customer.update');
Route::get('/customer/{id}/edit', 'CustomerController@edit');
Route::post('/customer/destroy', 'CustomerController@destroy')->name('customer.delete');

/// Car Sale Route Handler
Route::get('/car/sale/create', 'SaleController@create')->name('car.sale.create');
Route::get('/car/sale', 'SaleController@index')->name('car.sale.show');
Route::post('/car/sale/store', 'SaleController@store');
Route::post('/car/sale/ajaxDatatable', 'SaleController@index')->name('car.sale.showajax');
Route::post('/car/sale/update', 'SaleController@update')->name('car.sale.update');
Route::get('/car/sale/edit/{id}', 'SaleController@edit');
Route::post('/car/sale/destroy', 'SaleController@destroy')->name('car.sale.delete');
Route::post('/car/sale/payment', 'SaleController@addPayment')->name('car.sale.payment');
Auth::routes();