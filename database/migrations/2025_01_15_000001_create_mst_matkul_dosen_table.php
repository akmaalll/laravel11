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
        Schema::create('mst_matkul_dosen', function (Blueprint $table) {
            $table->id();
            $table->char('nidn', 20);
            $table->string('matkul', 128);
            $table->timestamps();

            // $table->foreign('dosen_nidn')->references('nidn')->on('mst_dosens')->onDelete('cascade');
            // $table->index(['dosen_nidn', 'mata_kuliah']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_matkul_dosen');
    }
};
