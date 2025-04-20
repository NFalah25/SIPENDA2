<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('arsip_pensiun', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->string('nomor_pegawai')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->datetime('tanggal_diterima')->nullable();
            $table->string('dokumen1')->nullable();
            $table->string('dokumen2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_pensiun');
    }
};
