<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\CarManufacturer;
use App\Models\CarType;
use App\Models\CarColor;
use Validator;
use Log;
use DB;

class CarsController extends Controller
{

  public function getCars(Request $request){
    $cars = DB::table('cars')
              ->join('car_manufacturers', 'cars.manufacturer_id', '=', 'car_manufacturers.id')
              ->join('car_types', 'cars.type_id', '=', 'car_types.id')
              ->join('car_colors', 'cars.color_id', '=', 'car_colors.id')
              ->select('cars.id AS carId', 'cars.name AS carName', 'car_manufacturers.id AS carManufacturerId', 'car_manufacturers.name AS carManufacturer', 'car_types.id AS carTypeId', 'car_types.name AS carType', 'car_colors.id AS carColorId', 'car_colors.name AS carColor')
              ->orderBy('cars.id')
              ->get();

    return response(
      [
        'cars' => $cars
      ]);
  }

  public function getDropdownValues(Request $request){

    $carManufacturers = CarManufacturer::all();
    $carTypes = CarType::all();
    $carColors = CarColor::all();

    return response(
      [
        'manufacturers' =>  $carManufacturers,
        'types' => $carTypes,
        'colors' => $carColors
      ]);
  }

  public function createCar(Request $request){

    $validator = Validator::make($request->all(),[
      'carName' => 'required|string',
      'carManufacturerId' => 'required',
      'carTypeId' => 'required',
      'carColorId' => 'required'
    ]);

    if ($validator->fails()) {
      $error_array = array();
      foreach ($validator->messages()->getMessages() as $field_name => $messages) {
          $error_array[$field_name] = $messages;
      }
      return response()->json(
          [
              'name' => 'cars',
              'response' => 400,
              'success' => false,
              'errors' => $error_array
          ], 400);
    }

    $carManufacturers = CarManufacturer::all();
    $carTypes = CarType::all();
    $carColors = CarColor::all();

    $car = new Car();
    $car->name = $request->input('carName');
    $car->manufacturer_id = $request->input('carManufacturerId');
    $car->type_id = $request->input('carTypeId');
    $car->color_id = $request->input('carColorId');

    $car->save();

    return response(
      [
        'success' => true,
        'message' => 'Successfully created a car',
        'car' => $car
      ]);
  }

  public function deleteCar($id){

    Car::where('id', $id)->delete();

    return response(
      [
        'success' => true,
        'message' => 'Successfully deleted a car',
      ]);
  }

  public function updateCar($id, Request $request){

    $validator = Validator::make($request->all(),[
      'carName' => 'required|string',
      'carManufacturerId' => 'required',
      'carTypeId' => 'required',
      'carColorId' => 'required'
    ]);

    if ($validator->fails()) {
      $error_array = array();
      foreach ($validator->messages()->getMessages() as $field_name => $messages) {
          $error_array[$field_name] = $messages;
      }
      return response()->json(
          [
              'name' => 'cars',
              'response' => 400,
              'success' => false,
              'errors' => $error_array
          ], 400);
    }

    $car = Car::where('id', $id)->get()->first();
    $car->name = $request->input('carName');
    $car->manufacturer_id = $request->input('carManufacturerId');
    $car->type_id = $request->input('carTypeId');
    $car->color_id = $request->input('carColorId');

    $car->save();

    return response(
      [
        'success' => true,
        'message' => 'Successfully updated a car',
      ]);
  }
  
}
