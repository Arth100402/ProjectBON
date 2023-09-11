<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableActivitydevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activitydevice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projectactivitydetail_id');
            $table->foreign('projectactivitydetail_id')->references('id')->on('projectactivitydetail')->onDelete('cascade');
            $table->unsignedBigInteger('device_id');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->enum('status', ['Proses','Ditunda','Selesai']);
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
        Schema::dropIfExists('activitydevice');
    }
}
