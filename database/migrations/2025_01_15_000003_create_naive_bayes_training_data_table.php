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
        Schema::create('naive_bayes_training_data', function (Blueprint $table) {
            $table->id();
            $table->string('pengajuan_id', 36); // UUID dari pengajuan judul
            $table->string('dosen_nidn', 20);
            $table->text('judul_skripsi');
            $table->string('topik_skripsi', 100);
            $table->text('keahlian_dosen'); // JSON array keahlian
            $table->text('mata_kuliah_dosen'); // JSON array mata kuliah
            $table->text('history_bimbingan'); // JSON array topik bimbingan sebelumnya
            $table->text('history_penelitian'); // JSON array topik penelitian
            $table->enum('hasil_pembimbingan', ['berhasil', 'kurang_berhasil', 'gagal'])->default('berhasil');
            $table->decimal('nilai_skripsi', 3, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->boolean('is_training_data')->default(true);
            $table->timestamps();

            $table->foreign('pengajuan_id')->references('id')->on('pengajuan_juduls')->onDelete('cascade');
            $table->foreign('dosen_nidn')->references('nidn')->on('mst_dosens')->onDelete('cascade');
            $table->index(['dosen_nidn', 'topik_skripsi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naive_bayes_training_data');
    }
};
