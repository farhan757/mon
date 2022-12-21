<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_soft', function (Blueprint $table) {
            //
            $table->id();
            $table->bigInteger('id_master_data');
            $table->string('awb',35);
            $table->string('tipe',50);
            $table->date('date_proses');
            $table->bigInteger('koli')->default(0);
            $table->bigInteger('weight')->default(0);
            $table->string('desti_kota',125)->nullable();
            $table->string('no_order',50)->nullable();
            $table->string('consignee_name',125)->nullable();
            $table->string('consignee_address',500)->nullable();
            $table->string('consignee_telp',125)->nullable();
            $table->string('service_tipe',100)->nullable();
            $table->string('value_cod',100)->nullable();
            $table->string('remarks',125)->nullable();
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
        Schema::dropIfExists('data_soft');
    }
};
