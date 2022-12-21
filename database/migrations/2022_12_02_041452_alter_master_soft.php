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
        Schema::table('master_soft', function (Blueprint $table) {
            //
            $table->integer('id_status_last')->after('cycle');
            $table->string('nm_file2',125)->after('nm_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_soft', function (Blueprint $table) {
            //
        });
    }
};
