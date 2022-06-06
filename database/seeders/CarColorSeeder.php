<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarColor;

class CarColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->getCarColor('Black') == null) {
          $carColor = new CarColor();
          $carColor->name = 'Black';
          $carColor->save();
        }

        if ($this->getCarColor('Red') == null) {
          $carColor = new CarColor();
          $carColor->name = 'Red';
          $carColor->save();
        }
    }

    private function getCarColor($colorName){
      return CarColor::where('name', $colorName)->first();
    }
}
