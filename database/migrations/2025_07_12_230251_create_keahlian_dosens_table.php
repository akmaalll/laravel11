<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update FK di dosen_mata_kuliah
        Schema::table('dosen_mata_kuliah', function (Blueprint $table) {
            $table->dropForeign(['dosen_nidn']); // drop FK lama
            $table->foreign('dosen_nidn')
                ->references('nidn')
                ->on('mst_dosens')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Update FK di mst_keahlian_dosens
        Schema::table('mst_keahlian_dosens', function (Blueprint $table) {
            $table->dropForeign(['dosen_id']); // drop FK lama
            $table->foreign('dosen_id')
                ->references('nidn')
                ->on('mst_dosens')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Kalau ada tabel lain yang pakai nidn sebagai FK, tambahkan di sini
    }

    public function down(): void
    {
        // Revert ke FK tanpa onUpdate cascade (opsional)
        Schema::table('dosen_mata_kuliah', function (Blueprint $table) {
            $table->dropForeign(['dosen_nidn']);
            $table->foreign('dosen_nidn')
                ->references('nidn')
                ->on('mst_dosens')
                ->onDelete('cascade');
        });

        Schema::table('mst_keahlian_dosens', function (Blueprint $table) {
            $table->dropForeign(['dosen_id']);
            $table->foreign('dosen_id')
                ->references('nidn')
                ->on('mst_dosens')
                ->onDelete('cascade');
        });
    }
};
