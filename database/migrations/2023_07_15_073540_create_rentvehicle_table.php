<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentvehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentvehicle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicles_id');
            $table->foreign('vehicles_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('tglSewa');
            $table->date('tglSelesai');
            $table->text('tujuan');
            $table->double('biayaSewa')->nullable();
            $table->integer('kmAwal')->nullable();
            $table->integer('kmAkhir')->nullable();
            $table->double('totalLiter')->nullable();
            $table->string('lokasiPengisian')->nullable();
            $table->enum('status', ['Internal', 'External']);
            $table->enum('acc', ["Diproses", "Ditolak", "Diterima","Selesai"]);
            $table->text('keteranganTolak')->nullable();
            $table->string('image');
            $table->string('imagekmawalakhir')->nullable();
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
        Schema::table('rentvehicle', function (Blueprint $table) {
            $table->dropForeign(['vehicles_id']);
            $table->dropColumn(['vehicles_id']);
            $table->dropForeign(['users_id']);
            $table->dropColumn(['users_id']);
        });
        Schema::dropIfExists('rentvehicle');
    }
}
