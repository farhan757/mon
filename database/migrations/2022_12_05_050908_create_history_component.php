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
        Schema::create('history_component', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_master_data');
            $table->string('keterangan',25);
            $table->bigInteger('id_material');
            $table->bigInteger('qty');
            $table->bigInteger('price');
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
        Schema::dropIfExists('history_component');
    }
};
