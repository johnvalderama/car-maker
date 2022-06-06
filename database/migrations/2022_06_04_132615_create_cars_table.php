<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('manufacturer_id')->unsigned();
            $table->bigInteger('type_id')->unsigned();
            $table->bigInteger('color_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('cars', function (Blueprint $table) {
          $table->foreign('manufacturer_id')->references('id')->on('car_manufacturers');
          $table->foreign('type_id')->references('id')->on('car_types');
          $table->foreign('color_id')->references('id')->on('car_colors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
