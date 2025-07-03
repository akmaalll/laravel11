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
        Schema::create('pembimbings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dosen');
            $table->string('id_judul', 100);
            $table->enum('peran', ['pembimbing_1', 'pembimbing_2'])->default('pembimbing_1');
            $table->timestamps();

            $table->foreign('id_dosen')->references('id')->on('mst_dosens')->onDelete('cascade');
            $table->foreign('id_judul')->references('id')->on('pengajuan_juduls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbings');
    }
};
