<?php

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('users', 'UsersController');
Route::resource('sectors', 'SectorsController');
Route::resource('clients', 'ClientsController');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('time/add', 'TimerController@store');
Route::get('time/{clientID}', 'TimerController@get');

Route::resource('reports', 'ReportController');
Route::post('reports/byuser', 'ReportController@filterByUser')->name('reports.byuser');
Route::post('reports/bysector', 'ReportController@filterBySector')->name('reports.bysector');
