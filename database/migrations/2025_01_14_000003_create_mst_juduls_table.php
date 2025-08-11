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
        Schema::create('mst_juduls', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('topik', 100);
            $table->unsignedBigInteger('id_prodi');
            $table->string('nidn_p1', 20)->nullable(); // boleh kosong
            $table->string('nidn_p2', 20)->nullable(); // boleh kosong
            $table->timestamps();

            $table->foreign('id_prodi')->references('id')->on('mst_prodis')->onDelete('cascade');
            $table->foreign('nidn_p1')->references('nidn')->on('mst_dosens')->nullOnDelete();
            $table->foreign('nidn_p2')->references('nidn')->on('mst_dosens')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_juduls');
    }
};
