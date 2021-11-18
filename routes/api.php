<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => ['sessions']], function (){
    Route::get('/ongs', 'OngsController@index');
    Route::post('/ongs', 'OngsController@store');

    Route::post('/session', 'SessionController@store');
    Route::delete('/session', 'SessionController@delete');

    Route::get('/incidents', 'IncidentsController@index');
    Route::get('/incidents/show/{id}', 'IncidentsController@show');
    Route::post('/incidents', 'IncidentsController@store');
    Route::delete('/incidents/{id}', 'IncidentsController@delete');

    Route::get('/profile', 'ProfileController@index');
});
