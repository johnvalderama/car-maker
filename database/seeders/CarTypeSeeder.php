<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarType;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->getCarType('Sedan') == null) {
          $carType = new CarType();
          $carType->name = 'Sedan';
          $carType->save();
        }

        if ($this->getCarType('SUV') == null) {
          $carType = new CarType();
          $carType->name = 'SUV';
          $carType->save();
        }
    }

    private function getCarType($typeName){
      return CarType::where('name', $typeName)->first();
    }
}
