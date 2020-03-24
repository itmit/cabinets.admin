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
    Route::post('clients/paid', 'Web\ClientWebController@paid');
    Route::post('clients/cancel', 'Web\ClientWebController@cancelReservation');

    Route::post('clients/archive', 'Web\ClientWebController@archive');
    Route::post('clients/unarchive', 'Web\ClientWebController@unarchive');

    Route::resource('cabinets', 'Web\CabinetWebController');
    Route::post('cabinets/deletePhoto', 'Web\CabinetWebController@deletePhoto');

    Route::resource('calendar', 'Web\CalendarController');
    Route::post('calendar/getOneDay', 'Web\CalendarController@getOneDay');
    Route::post('calendar/getFewDay', 'Web\CalendarController@getFewDay');

    Route::resource('reservations', 'Web\ReservationController');
    Route::post('reservations/getTimes', 'Web\ReservationController@getTimes');

    Route::resource('pushes', 'Web\PushController');
    Route::post('sendPush', 'Web\PushController@sendPush');

    Route::post('reservationcancels', 'Web\ReservationController@reservationcancels')->name('reservationcancels');
    
});

Auth::routes();
