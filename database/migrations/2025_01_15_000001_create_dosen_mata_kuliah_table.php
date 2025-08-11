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
        Schema::create('dosen_mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('dosen_nidn', 20);
            $table->string('mata_kuliah', 100);
            $table->string('kode_mk', 20)->nullable();
            $table->string('semester', 10)->nullable(); 
            $table->timestamps();

            $table->foreign('dosen_nidn')->references('nidn')->on('mst_dosens')->onDelete('cascade');
            $table->index(['dosen_nidn', 'mata_kuliah']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_mata_kuliah');
    }
};
