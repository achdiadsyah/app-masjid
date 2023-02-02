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
        Schema::create('jadwal_pengajians', function (Blueprint $table) {
            $table->id();
            $table->enum('pengajian', ['shubuh', 'magrib', 'wanita']);
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('pengisi_kajian');
            $table->string('keterangan_pengisi_kajian');
            $table->string('topik_kajian');
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
        Schema::dropIfExists('jadwal_pengajians');
    }
};
