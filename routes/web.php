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

    return redirect('/report');
});
Route::get('logout', function () {

    return redirect('login');
});

//// Car Hire/Buying Route Handler
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
Route::get('/car/sale/payment', 'SaleController@getPaymentList');
Route::post('/car/sale/payment/destroy', 'SaleController@paymentDestroy');
Route::post('/car/sale/payment', 'SaleController@addPayment')->name('car.sale.payment');

///// Persoanl Car `Add` Router  Handler

Route::get('personal/car/', 'PersonalCarAddController@index')->name('personal.car');
Route::post('personal/car/ajaxDatatable', 'PersonalCarAddController@index')->name('personal.car.add.showajax');
Route::post('personal/car/add/store', 'PersonalCarAddController@store')->name('personal.car.add.store');
Route::post('personal/car/add/update', 'PersonalCarAddController@update')->name('personal.car.add.update');
Route::get('/personal/car/add/{id}/edit', 'PersonalCarAddController@edit');
Route::post('/personal/car/add/destroy', 'PersonalCarAddController@destroy')->name('personalCarDelete');

///// Personal Car  `Hire` Router Handler

Route::get('personal/car/hire', 'PersonalCarHireController@index')->name('personal.car.hire');
Route::post('personal/car/hire/ajaxDatatable', 'PersonalCarHireController@index')->name('personal.car.hire.showajax');
Route::post('personal/car/hire/hire/store', 'PersonalCarHireController@store')->name('personal.car.hire.store');
Route::post('personal/car/hire/update', 'PersonalCarHireController@update')->name('personal.car.hire.update');
Route::get('/personal/car/hire/{id}/edit', 'PersonalCarHireController@edit');
Route::post('/personal/car/hire/destroy', 'PersonalCarHireController@destroy')->name('personalCarDelete');
Route::get('personal/car/hire/payment', 'PersonalCarHireController@getPaymentList');
Route::post('personal/car/hire/payment/destroy', 'PersonalCarHireController@paymentDestroy');
Route::post('personal/car/hire/payment', 'PersonalCarHireController@addPayment')->name('personal.car.hire.payment');
Route::post('/personal/car/hire/end', 'PersonalCarHireController@hireEnd')->name('personalCarHireEnd');

//// Report Controller

Route::get('/report', 'ReportController@index');
Route::post('/report/ajax', 'ReportController@getReport');
//// Authenticate Route
Auth::routes([
    'register' => true,
]);