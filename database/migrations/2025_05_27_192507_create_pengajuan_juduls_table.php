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
        Schema::create('pengajuan_juduls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('id_prodi');
            $table->string('judul');
            $table->string('topik', 100);
            $table->string('konsentrasi', 50);
            $table->string('objek_penelitian');
            $table->text('latar_belakang');
            $table->text('rumusan_masalah');
            $table->text('tujuan_penelitian');
            $table->text('penelitian_terkait');
            $table->enum('status', ['diajukan', 'diverifikasi', 'ditolak', 'diterima'])->default('diajukan');
            $table->timestamps();

            $table->foreign('id_prodi')->references('id')->on('mst_prodis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_juduls');
    }
};
