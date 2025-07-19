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
        Schema::create('mst_keahlian_dosens', function (Blueprint $table) {
            $table->string('dosen_id'); // Mengacu ke id (bukan nidn) di mst_dosens
            $table->string('keahlian_id', 10); // Mengacu ke id di mst_keahlians

            $table->foreign('dosen_id')->references('nidn')->on('mst_dosens')->onDelete('cascade');
            $table->foreign('keahlian_id')->references('id')->on('mst_keahlians')->onDelete('cascade');

            $table->primary(['dosen_id', 'keahlian_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_keahlian_dosens');
    }
};
