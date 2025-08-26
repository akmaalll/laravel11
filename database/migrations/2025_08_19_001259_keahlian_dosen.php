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
        // DB::statement("CREATE VIEW KeahlianDosenView AS
        //                 SELECT
        //             mst_dosen.nidn,
        //             mst_dosen.nama,
        //             mst_matkul_dosen.matkul,
        //             mst_keahlian.id id_keahlian,
        //             mst_keahlian.nama keahlian
        //             FROM mst_dosen
        //             RIGHT join mst_matkul_dosen on mst_matkul_dosen.nidn = mst_dosen.nidn
        //             RIGHT join mst_keahlian_dosen on mst_keahlian_dosen.id_matkul_dosen = mst_matkul_dosen.id
        //             LEFT JOIN mst_keahlian on mst_keahlian.id = mst_keahlian_dosen.id_keahlian
        //         ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::statement("DROP VIEW companiesView");
    }
};
