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
        Schema::create('atribut', function (Blueprint $table) {
            $table->id();
            $table->char('kode', 2);
            $table->string('nama', 50);
            $table->integer('nilai_awal');
            $table->integer('nilai_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atribut');
    }
};
