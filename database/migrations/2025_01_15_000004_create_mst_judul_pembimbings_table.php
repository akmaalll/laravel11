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
        Schema::create('mst_judul_pembimbings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_judul'); // ID dari mst_juduls
            $table->string('dosen_nidn', 20); // NIDN dari mst_dosens
            $table->enum('peran', ['pembimbing_1', 'pembimbing_2'])->default('pembimbing_1');
            $table->enum('status_pembimbingan', ['berhasil', 'kurang_berhasil', 'gagal'])->default('berhasil');
            $table->decimal('nilai_skripsi', 3, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_judul')->references('id')->on('mst_juduls')->onDelete('cascade');
            $table->foreign('dosen_nidn')->references('nidn')->on('mst_dosens')->onDelete('cascade');
            $table->unique(['id_judul', 'dosen_nidn', 'peran']);
            $table->index(['dosen_nidn', 'status_pembimbingan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_judul_pembimbings');
    }
};
