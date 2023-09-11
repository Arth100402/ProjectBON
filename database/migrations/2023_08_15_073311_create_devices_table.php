<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('deviceCategory_id');
            $table->foreign('deviceCategory_id')->references('id')->on('deviceCategory')->onDelete('cascade');
            $table->string('tipe');
            $table->string('merk');
            $table->string('ipaddress')->nullable();
            $table->string('port')->nullable();
            $table->string('serialnumber')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string("image");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
