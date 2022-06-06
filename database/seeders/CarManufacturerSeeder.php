<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarManufacturer;

class CarManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->getCarManufacturer('Toyota') == null) {
          $carManufacturer = new CarManufacturer();
          $carManufacturer->name = 'Toyota';
          $carManufacturer->save();
        }

        if ($this->getCarManufacturer('Honda') == null) {
          $carManufacturer = new CarManufacturer();
          $carManufacturer->name = 'Honda';
          $carManufacturer->save();
        }
    }

    private function getCarManufacturer($manufacturerName){
      return CarManufacturer::where('name', $manufacturerName)->first();
    }
}
