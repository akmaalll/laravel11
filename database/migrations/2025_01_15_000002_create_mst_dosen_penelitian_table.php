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
        Schema::create('mst_dosen_penelitian', function (Blueprint $table) {
            $table->id();
            $table->char('nidn', 20);
            $table->string('judul_penelitian', 200);

            // $table->foreign('dosen_nidn')->references('nidn')->on('mst_dosens')->onDelete('cascade');
            // $table->foreign('keahlian_id')->references('id')->on('mst_keahlians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_dosen_penelitian');
    }
};
