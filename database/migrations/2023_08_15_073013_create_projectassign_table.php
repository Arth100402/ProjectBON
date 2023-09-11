<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectassignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectassign', function (Blueprint $table) {
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('projectactivitydetail_id');
            $table->foreign('projectactivitydetail_id')->references('id')->on('projectactivitydetail')->onDelete('cascade');
            $table->unsignedBigInteger('roles_id');
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unique(["users_id", "projectactivitydetail_id"]);
            $table->text('keterangan')->nullable();
            $table->time('waktuTiba')->nullable();
            $table->time('waktuSelesai')->nullable();
            $table->string('image')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('projectassign');
    }
}
