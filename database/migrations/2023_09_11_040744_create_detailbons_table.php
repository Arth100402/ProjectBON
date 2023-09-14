<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailbonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailbons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bons_id');
            $table->foreign('bons_id')->references('id')->on('bons')->onDelete('cascade');
            $table->date("tglMulai");
            $table->date("tglAkhir");
            $table->string("asalKota");
            $table->string("tujuan");
            $table->unsignedBigInteger('projects_id');
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("noPaket")->nullable();
            $table->text('agenda');
            $table->string('penggunaan')->nullable();
            $table->integer('biaya');
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
        Schema::dropIfExists('detailbons');
    }
}
