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
            $table->unsignedBigInteger('jabatanPengaju');
            $table->foreign('jabatanPengaju')->references('id')->on('jabatans')->onDelete('cascade');
            $table->unsignedBigInteger('jabatanAcc');
            $table->foreign('jabatanAcc')->references('id')->on('jabatans')->onDelete('cascade');
            $table->enum("status", ["enable", "disable"]);
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
