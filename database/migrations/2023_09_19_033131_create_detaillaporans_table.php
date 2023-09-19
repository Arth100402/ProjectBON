<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetaillaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detaillaporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporans_id');
            $table->foreign('laporans_id')->references('id')->on('laporans')->onDelete('cascade');
            $table->date("tanggal");
            $table->unsignedBigInteger('projects_id');
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('types_id');
            $table->foreign('types_id')->references('id')->on('types')->onDelete('cascade');
            $table->string("vendor");
            $table->text('keterangan');
            $table->double('pengeluaran');
            $table->unsignedBigInteger('bons_id');
            $table->foreign('bons_id')->references('id')->on('bons')->onDelete('cascade');
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
        Schema::dropIfExists('detaillaporans');
    }
}
