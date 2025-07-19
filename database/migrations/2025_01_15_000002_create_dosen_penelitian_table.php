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
        Schema::create('dosen_penelitian', function (Blueprint $table) {
            $table->id();
            $table->string('dosen_nidn', 20);
            $table->string('judul_penelitian', 200);
            $table->text('topik_penelitian');
            $table->string('jenis_penelitian', 50)->nullable(); // Penelitian Dasar/Terapan/Pengembangan
            $table->string('skema_penelitian', 50)->nullable(); // Hibah, Mandiri, dll
            $table->year('tahun_penelitian');
            $table->string('status', 20)->default('selesai'); // sedang_berlangsung, selesai, dibatalkan
            $table->text('abstrak')->nullable();
            $table->string('file_penelitian')->nullable();
            $table->timestamps();

            $table->foreign('dosen_nidn')->references('nidn')->on('mst_dosens')->onDelete('cascade');
            $table->index(['dosen_nidn', 'topik_penelitian']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_penelitian');
    }
};
