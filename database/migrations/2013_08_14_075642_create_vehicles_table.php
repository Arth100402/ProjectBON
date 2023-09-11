<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->string('kategori');
            $table->string('merk');
            $table->string('tipe');
            $table->string('warna');
            $table->string('tahun');
            $table->string('noMesin');
            $table->string('noKerangka');
            $table->string("noPol");
            $table->string('noPolLama')->nullable();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->date('tanggalBayarPajakTahunan')->nullable();
            $table->date('masaBerlakuSTNK')->nullable();
            $table->string('atasNamaSTNK');
            $table->string('posisiBPKB');
            $table->date('tanggalKIR')->nullable();
            $table->string("kodeGPS");
            $table->string("namaGPS");
            $table->string("kodeBarcode");
            $table->date('tglBayarGPS')->nullable();
            $table->enum("statusSedia", ["Tersedia", "Dipakai"]);
            $table->string('image');
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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn(['location_id']);
        });
        Schema::dropIfExists('vehicles');
    }
}
