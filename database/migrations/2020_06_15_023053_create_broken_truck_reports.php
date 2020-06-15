<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrokenTruckReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broken_truck_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('truck_id');
            $table->foreign('truck_id')->references('id')->on('trucks');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('status');
            $table->text('description')->nullable();
            $table->json('images')->default('[]');
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
        Schema::dropIfExists('broken_truck_reports');
    }
}
