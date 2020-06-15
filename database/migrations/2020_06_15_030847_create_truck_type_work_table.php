<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckTypeWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_type_work', function (Blueprint $table) {
            $table->unsignedInteger('truck_type_id');
            $table->foreign('truck_type_id')->references('id')->on('truck_types');
            $table->unsignedInteger('work_id');
            $table->foreign('work_id')->references('id')->on('works');
            $table->tinyInteger('quantity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('truck_type_work');
    }
}
