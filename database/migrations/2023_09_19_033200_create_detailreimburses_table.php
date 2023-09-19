<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailreimbursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailreimburses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reimburses_id');
            $table->foreign('reimburses_id')->references('id')->on('reimburses')->onDelete('cascade');
            $table->date("tanggal");
            $table->string("kota");
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
            $table->integer('quantity');
            $table->double('biaya');
            $table->double('pengeluaran');
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
        Schema::dropIfExists('detailreimburses');
    }
}
