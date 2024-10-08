<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('idOpti');
            $table->string('namaOpti');
            $table->string('instansi')->nullable();
            $table->unsignedBigInteger('customers_id');
            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('telepon')->nullable();
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('tglBuat')->nullable();
            $table->date('tglRealisasi');
            $table->text('kebutuhan')->nullable();
            $table->text('actplan')->nullable();
            $table->bigInteger('estNominal')->nullable();
            $table->enum('status', ['Batal','Menunggu', 'Proses','Ditunda','Selesai']);
            $table->string('statusBarang')->nullable();
            $table->string('statusRevisi')->nullable();
            $table->string('posisi');
            $table->string('statusBarangReady')->nullable();
            $table->string('statusPinjam')->nullable();
            $table->string('divisi')->nullable();
            $table->string('pbar')->nullable();
            $table->string('onUpdate')->nullable();
            $table->bigInteger('totalPaket')->nullable();
            $table->bigInteger('profitDouble')->nullable();
            $table->bigInteger('profitSingle')->nullable();
            $table->integer('statusRegisterPortal')->nullable();
            $table->date('deadline');
            $table->string('noPaket');
            $table->string('bendera');
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
        Schema::dropIfExists('projects');
    }
}
