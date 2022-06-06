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

class AdminController extends Controller
{

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

  public function createManufacturer(Request $request){

    $carManufacturer = new CarManufacturer();
    $carManufacturer->name = $request->input('name');

    $carManufacturer->save();

    return response(
      [
        'success' => true,
        'message' => 'Successfully created a car manufacturer',
        'carManufacturer' => $carManufacturer
      ]);
  }

  public function deleteManufacturer($id){

    CarManufacturer::where('id', $id)->delete();

    return response(
      [
        'success' => true,
        'message' => 'Successfully deleted a car manufacturer',
      ]);
  }

  public function updateManufacturer($id, Request $request){

    $carManufacturer = CarManufacturer::where('id', $id)->get()->first();
    $carManufacturer->name = $request->input('name');

    $carManufacturer->save();

    return response(
      [
        'success' => true,
        'message' => 'Successfully updated a car manufacturer',
      ]);
  }

  public function createType(Request $request){

    $carType = new CarType();
    $carType->name = $request->input('name');

    $carType->save();

    return response(
      [
        'success' => true,
        'message' => 'Successfully created a car type',
        'carType' => $carType
      ]);
  }

  public function deleteType($id){

    CarType::where('id', $id)->delete();

    return response(
      [
        'success' => true,
        'message' => 'Successfully deleted a car type',
      ]);
  }

  public function updateType($id, Request $request){

    $carType = CarType::where('id', $id)->get()->first();
    $carType->name = $request->input('name');

    $carType->save();

    return response(
      [
        'success' => true,
        'message' => 'Successfully updated a car type',
      ]);
  }

  public function createColor(Request $request){

    $carColor = new CarColor();
    $carColor->name = $request->input('name');

    $carColor->save();

    return response(
      [
        'success' => true,
        'message' => 'Successfully created a car color',
        'car' => $carColor
      ]);
  }

  public function deleteColor($id){

    CarColor::where('id', $id)->delete();

    return response(
      [
        'success' => true,
        'message' => 'Successfully deleted a car color',
      ]);
  }

  public function updateColor($id, Request $request){

    $carColor = CarColor::where('id', $id)->get()->first();
    $carColor->name = $request->input('name');

    $carColor->save();

    return response(
      [
        'success' => true,
        'message' => 'Successfully updated a car color',
      ]);
  }
  
}
