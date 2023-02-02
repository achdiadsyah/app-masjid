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
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('revision_id')->unique();
            $table->integer('interval');
            $table->enum('is_ticker', ['1', '0']);
            $table->enum('is_gallery', ['1', '0']);
            $table->enum('is_idfitri', ['1', '0']);
            $table->enum('is_idadha', ['1', '0']);
            $table->enum('is_ramadhan', ['1', '0']);
            $table->string('ketua_bkm');
            $table->string('bendahara_bkm');
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
        Schema::dropIfExists('app_settings');
    }
};
