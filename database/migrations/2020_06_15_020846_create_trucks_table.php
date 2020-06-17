<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('owner_name')->nullable();
            $table->string('number_plate')->unique();
            $table->unsignedInteger('truck_manufacturer_id');
            $table->foreign('truck_manufacturer_id')->references('id')->on('truck_manufacturers');
            $table->unsignedInteger('truck_type_id');
            $table->foreign('truck_type_id')->references('id')->on('truck_types');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('manufacturing_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trucks');
    }
}
