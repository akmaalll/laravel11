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
        Schema::create('mst_judul', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('id_prodi');
            $table->integer('id_keahlian');
            $table->string('judul');
            $table->string('konsentrasi', 50)->nullable();
            $table->text('latar_belakang')->nullable();
            $table->text('rumusan_masalah')->nullable();
            $table->text('tujuan_penelitian')->nullable();
            $table->text('penelitian_terkait')->nullable();
            $table->string('objek_penelitian')->nullable();
            $table->char('nim1', 6);
            $table->char('nim2, 6')->nullable();
            $table->char('nidn1')->nullable();
            $table->char('nidn2')->nullable();
            $table->enum('status', ['diajukan', 'diverifikasi', 'ditolak', 'diterima'])->default('diajukan');
            $table->timestamps();

            // $table->foreign('id_prodi')->references('id')->on('mst_prodis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_judul');
    }
};
