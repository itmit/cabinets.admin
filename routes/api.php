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

    Route::get('events/getEventsByDate/{date}', 'Api\EventApiController@getEventsByDate');
    Route::post('events/registerOnEvent', 'Api\EventApiController@registerOnEvent');

    Route::get('news/index/{limit}/{offset}', 'Api\NewsApiController@index');

    Route::get('cases/index/{limit}/{offset}', 'Api\CaseApiController@index');

    Route::get('messenger/index', 'Api\MessengerApiController@index');
    Route::post('messenger/send', 'Api\MessengerApiController@send');

    Route::get('document/index', 'Api\DocumentApiController@index');

    Route::get('cabinets/index', 'Api\CabinetApiController@getListOfCabinets');
    Route::post('cabinets/show', 'Api\CabinetApiController@getCabinet');

    Route::get('news/index', 'Api\NewsApiController@getNewsList');
    Route::post('news/show', 'Api\NewsApiController@getNews');
    
});

Route::post('cabinets/selectDate', 'Api\CabinetReservationApiController@checkCabinetByDate');