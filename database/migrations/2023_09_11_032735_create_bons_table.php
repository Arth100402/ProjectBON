<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bons', function (Blueprint $table) {
            $table->id();
            $table->date("tglPengajuan");
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('total');
            $table->unsignedBigInteger('projects_id');
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');
            $table->enum('status', ['Terima','Tolak'])->nullable();
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
        Schema::dropIfExists('bons');
    }
}
