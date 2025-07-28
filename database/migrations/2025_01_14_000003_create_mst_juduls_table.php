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
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_prodi')->references('id')->on('mst_prodis')->onDelete('cascade');
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
