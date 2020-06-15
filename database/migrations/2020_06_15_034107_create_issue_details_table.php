<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('scrap_id');
            $table->foreign('scrap_id')->references('id')->on('scrap');
            $table->unsignedInteger('issue_id');
            $table->foreign('issue_id')->references('id')->on('issues');
            $table->float('quantity')->default(0);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('issue_details');
    }
}
