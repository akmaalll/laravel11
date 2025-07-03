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
        Schema::create('pengusul_juduls', function (Blueprint $table) {
            $table->id();
            $table->string('id_judul', 100);
            $table->string('nim', 6);
            $table->timestamps();

            $table->foreign('id_judul')->references('id')->on('pengajuan_juduls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengusul_juduls');
    }
};
