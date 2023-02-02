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
        Schema::create('jadwal_sholat_umums', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('sholat', ['subuh', 'dzuhur', 'ashar', 'magrib', 'isya']);
            $table->string('imam');
            $table->string('keterangan_imam');
            $table->string('muazin');
            $table->string('keterangan_muazin');
            $table->string('khatib')->nullable();
            $table->string('keterangan_khatib')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('jadwal_sholat_umums');
    }
};
