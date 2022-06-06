<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarManufacturer;
use App\Models\CarType;
use App\Models\CarColor;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carManufacturer = CarManufacturer::where('name', 'Toyota')->first();
        $carType = CarType::where('name', 'Sedan')->first();
        $carColor = CarColor::where('name', 'Red')->first();
        if ($this->getCar('Toyota Vios XLE CVT') == null) {
          $car = new Car();
          $car->name = 'Toyota Vios XLE CVT';
          $car->manufacturer_id = $carManufacturer->id;
          $car->type_id = $carType->id;
          $car->color_id = $carColor->id;
          $car->save();
        }
    }

    private function getCar($carName){
      return Car::where('name', $carName)->first();
    }
}
