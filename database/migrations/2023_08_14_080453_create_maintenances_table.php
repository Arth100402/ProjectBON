<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->date('tglMaintenance')->nullable();
            $table->text('keluhan');
            $table->double('totalBiaya');
            $table->double('hargaService');
            $table->integer('km');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('vehicles_id');
            $table->foreign('vehicles_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->unsignedBigInteger('workshops_id');
            $table->foreign('workshops_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->string('image');
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
        Schema::dropIfExists('maintenances');
    }
}
