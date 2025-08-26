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
            $table->string('nidn', 20);
            $table->string('nama', 50);
            $table->integer('jumlah_keahlian');
            $table->integer('jumlah_penelitian');
            $table->integer('jumlah_riwayat');
            $table->integer('rekomendasi');
            $table->timestamps();
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
