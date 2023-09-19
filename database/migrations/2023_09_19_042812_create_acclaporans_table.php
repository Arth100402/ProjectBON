<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcclaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acclaporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporans_id');
            $table->foreign('laporans_id')->references('id')->on('laporans')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['Terima','Diproses','Tolak'])->nullable();
            $table->string('keteranganTolak')->nullable();
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
        Schema::dropIfExists('acclaporans');
    }
}
