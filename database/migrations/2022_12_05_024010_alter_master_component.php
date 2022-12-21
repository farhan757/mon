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
        Schema::table('master_component', function (Blueprint $table) {
            //
            $table->bigInteger('stok')->default(0)->after('nm_component');
            $table->bigInteger('price')->default(0)->after('stok');
            $table->bigInteger('supplier_id')->default(0)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_component', function (Blueprint $table) {
            //
        });
    }
};
