<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bons_id');
            $table->foreign('bons_id')->references('id')->on('bons')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['Terima', 'Diproses', 'Revisi', 'Tolak'])->nullable();
            $table->integer('level')->default('0');
            $table->integer('threshold')->default("0");
            $table->integer('thresholdChange')->default("0");
            $table->string('keteranganAcc')->nullable();
            $table->string('keteranganTolak')->nullable();
            $table->string('keteranganRevisi')->nullable();
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
        Schema::dropIfExists('accs');
    }
}
