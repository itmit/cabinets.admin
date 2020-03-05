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

Route::group(['as' => 'auth.', 'middleware' => 'auth'], function () {
    
    Route::get('/', ['as' => 'home', 'uses' => 'Web\NewsWebController@index']);

    Route::resource('news', 'Web\NewsWebController');

    Route::resource('clients', 'Web\ClientWebController');

    Route::resource('cabinets', 'Web\CabinetWebController');

    Route::resource('calendar', 'Web\CalendarController');

    Route::post('calendar/getOneDay', 'Web\CalendarController@getOneDay');
    Route::post('calendar/getFewDay', 'Web\CalendarController@getFewDay');

    Route::post('clients/paid', 'Web\ClientWebController@paid');

    Route::post('cabinets/deletePhoto', 'Web\CabinetWebController@deletePhoto');
    
});

Auth::routes();
