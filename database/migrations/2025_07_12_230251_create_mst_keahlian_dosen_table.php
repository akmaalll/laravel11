<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mst_keahlian_dosen', function (Blueprint $table) {
            $table->id();
            $table->integer('id_matkul_dosen');
            $table->integer('id_keahlian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mst_keahlian_dosen');
    }
};
