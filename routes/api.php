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

Route::post('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'api\LoginController@login');
Route::middleware('auth:api')->post('/logout', 'api\LoginController@logout');

//CRUD for cars
Route::middleware('auth:api')->post('/cars','api\CarsController@getCars');
Route::middleware('auth:api')->post('/car','api\CarsController@createCar');
Route::middleware('auth:api')->put('/car/{id}','api\CarsController@updateCar');
Route::middleware('auth:api')->delete('/car/{id}','api\CarsController@deleteCar');

Route::middleware('auth:api')->post('/dropdown-values','api\CarsController@getDropdownValues');

//CRUD for manufacturers
Route::middleware('auth:api')->post('/manufacturer','api\AdminController@createManufacturer');
Route::middleware('auth:api')->put('/manufacturer/{id}','api\AdminController@updateManufacturer');
Route::middleware('auth:api')->delete('/manufacturer/{id}','api\AdminController@deleteManufacturer');

//CRUD for types
Route::middleware('auth:api')->post('/type','api\AdminController@createType');
Route::middleware('auth:api')->put('/type/{id}','api\AdminController@updateType');
Route::middleware('auth:api')->delete('/type/{id}','api\AdminController@deleteType');

//CRUD for colors
Route::middleware('auth:api')->post('/color','api\AdminController@createColor');
Route::middleware('auth:api')->put('/color/{id}','api\AdminController@updateColor');
Route::middleware('auth:api')->delete('/color/{id}','api\AdminController@deleteColor');
