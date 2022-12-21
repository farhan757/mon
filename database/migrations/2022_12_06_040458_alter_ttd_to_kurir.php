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
        Schema::table('ttd_to_kurir', function (Blueprint $table) {
            //
            $table->bigInteger('jml_awb')->after('id_master_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ttd_to_kurir', function (Blueprint $table) {
            //
        });
    }
};
