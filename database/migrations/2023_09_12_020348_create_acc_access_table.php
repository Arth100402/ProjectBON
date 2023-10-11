<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departId');
            $table->foreign('departId')->references('id')->on('departements')->onDelete('cascade');
            $table->unsignedBigInteger('idPengaju');
            $table->foreign('idPengaju')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('idAcc');
            $table->foreign('idAcc')->references('id')->on('users')->onDelete('cascade');
            $table->integer('threshold');
            $table->integer('thresholdChange');
            $table->integer('level');
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
        Schema::dropIfExists('acc_access');
    }
}
