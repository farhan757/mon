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
        Schema::create('master_soft', function (Blueprint $table) {
            //
            $table->id();
            $table->string('nm_file',150);
            $table->date('cycle');
            $table->integer('create_by');
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
        Schema::table('master_soft', function (Blueprint $table) {
            //
            Schema::dropIfExists('master_soft');
        });
    }
};
