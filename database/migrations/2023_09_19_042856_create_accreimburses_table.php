<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccreimbursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accreimburses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reimburses_id');
            $table->foreign('reimburses_id')->references('id')->on('reimburses')->onDelete('cascade');
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
        Schema::dropIfExists('accreimburses');
    }
}
