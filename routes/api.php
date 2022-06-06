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

Route::post('/login', 'api\LoginController@login');
Route::post('/logout', 'api\LoginController@logout');

//CRUD for cars
Route::post('/cars','api\CarsController@getCars');
Route::post('/car','api\CarsController@createCar');
Route::put('/car/{id}','api\CarsController@updateCar');
Route::delete('/car/{id}','api\CarsController@deleteCar');

Route::post('/dropdown-values','api\CarsController@getDropdownValues');

//CRUD for manufacturers
Route::post('/manufacturer','api\AdminController@createManufacturer');
Route::put('/manufacturer/{id}','api\AdminController@updateManufacturer');
Route::delete('/manufacturer/{id}','api\AdminController@deleteManufacturer');

//CRUD for types
Route::post('/type','api\AdminController@createType');
Route::put('/type/{id}','api\AdminController@updateType');
Route::delete('/type/{id}','api\AdminController@deleteType');

//CRUD for colors
Route::post('/color','api\AdminController@createColor');
Route::put('/color/{id}','api\AdminController@updateColor');
Route::delete('/color/{id}','api\AdminController@deleteColor');
