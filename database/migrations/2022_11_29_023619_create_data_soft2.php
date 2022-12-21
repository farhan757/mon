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
        Schema::create('data_soft2', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_master_data');
            $table->string('awb',35);
            $table->string('nama',150);
            $table->string('bank',50);
            $table->text('address');
            $table->string('no_sertifikat',50);
            $table->string('jenis_dok',25);
            $table->string('tgl_kirim',25);
            $table->string('media_pengiriman',25);
            $table->string('status_pengiriman',25);
            $table->string('tgl_terima',25);
            $table->string('nama_penerima',120);
            $table->string('sla',5);
            $table->string('keterangan',150);
            $table->string('remarks',250);
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
        Schema::dropIfExists('data_soft2');
    }
};
