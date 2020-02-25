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

Route::post('login', 'Api\AuthApiController@login');
Route::post('register', 'Api\AuthApiController@register');
Route::post('logout', 'Api\AuthApiController@logout');

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('cabinets/index', 'Api\CabinetApiController@getListOfCabinets');
    Route::post('cabinets/show', 'Api\CabinetApiController@getCabinet');
    Route::post('cabinets/selectDate', 'Api\CabinetReservationApiController@checkCabinetByDate');
    Route::post('cabinets/makeReservation', 'Api\CabinetReservationApiController@makeReservation');
    Route::post('cabinets/cancelReservation', 'Api\CabinetReservationApiController@cancelReservation');
    Route::post('cabinets/updateReservation', 'Api\CabinetReservationApiController@updateReservation');
    Route::post('cabinets/getBusyCabinetsByDate', 'Api\CabinetReservationApiController@getBusyCabinetsByDate');

    Route::get('user/myReservations', 'Api\CabinetReservationApiController@getUsersReservations');
    Route::post('user/myReservations/detail', 'Api\CabinetReservationApiController@getUsersReservationDetail');
    Route::get('user/getAmount', 'Api\CabinetReservationApiController@getAmount');
    Route::post('user/updateDeviceToken', 'Api\UserController@updateDeviceToken');

    Route::get('news/index', 'Api\NewsApiController@getNewsList');
    Route::post('news/show', 'Api\NewsApiController@getNews');

    
    
});
Route::get('test', 'Api\UserController@test');
