<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE VIEW PenelitianDosenView AS
                       SELECT
                mst_dosen_penelitian.nidn,
                mst_dosen.nama,
                mst_dosen_penelitian.judul_penelitian,
                mst_keahlian.id as id_keahlian,
                mst_keahlian.nama as nama_keahlian
                FROM mst_dosen_penelitian
                LEFT JOIN mst_dosen ON mst_dosen.nidn = mst_dosen_penelitian.nidn
                RIGHT JOIN mst_keahlian_judul_dosen on mst_keahlian_judul_dosen.id_dosen_penelitian = mst_dosen_penelitian.id
                LEFT JOIN mst_keahlian on mst_keahlian.id = mst_keahlian_judul_dosen.id_keahlian

                ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS PenelitianDosenView");
    }
};
