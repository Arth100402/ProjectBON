<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectactivitydetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectactivitydetail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projects_id');
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('namaAktifitas')->nullable();
            $table->date("tglAktifitas");
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
        Schema::dropIfExists('projectactivitydetail');
    }
}
