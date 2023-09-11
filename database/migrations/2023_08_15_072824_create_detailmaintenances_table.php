<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailmaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailmaintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spareparts_id');
            $table->foreign('spareparts_id')->references('id')->on('spareparts')->onDelete('cascade');
            $table->double('subtotal');
            $table->unsignedBigInteger('maintenances_id');
            $table->foreign('maintenances_id')->references('id')->on('maintenances')->onDelete('cascade');
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
        Schema::table('detailmaintenances', function (Blueprint $table) {
            $table->dropForeign(['maintenances_id']);
            $table->dropColumn(['maintenances_id']);

        });
        Schema::dropIfExists('detailmaintenances');
    }
}
