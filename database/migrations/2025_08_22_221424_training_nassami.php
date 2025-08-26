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
        DB::statement("CREATE VIEW TrainingNassamiView AS
                        SELECT 
                    a.nidn,
                    a.nama,

                    (SELECT 
                    IF(a.jumlah_keahlian >= (SELECT b.nilai_awal FROM atribut b WHERE b.kode = 'A1' AND b.urut = 1) AND a.jumlah_keahlian <= (SELECT b.nilai_akhir FROM atribut b WHERE b.kode = 'A1' AND b.urut = 1),'BASIC',
                        IF(a.jumlah_keahlian >= (SELECT b.nilai_awal FROM atribut b WHERE b.kode = 'A1' AND b.urut = 2) AND a.jumlah_keahlian <= (SELECT b.nilai_akhir FROM atribut b WHERE b.kode = 'A1' AND b.urut = 2),'INTERMEDIETE','EXPERT'))) as label_keahlian,
                        
                    (SELECT 
                    IF(a.jumlah_penelitian >= (SELECT b.nilai_awal FROM atribut b WHERE b.kode = 'A2' AND b.urut = 1) AND a.jumlah_penelitian <= (SELECT b.nilai_akhir FROM atribut b WHERE b.kode = 'A2' AND b.urut = 1),'LITLE',
                        IF(a.jumlah_penelitian >= (SELECT b.nilai_awal FROM atribut b WHERE b.kode = 'A2' AND b.urut = 2) AND a.jumlah_penelitian <= (SELECT b.nilai_akhir FROM atribut b WHERE b.kode = 'A2' AND b.urut = 2),'MEDIUM','ANY'))) as label_penelitian,
                        
                    (SELECT 
                    IF(a.jumlah_riwayat >= (SELECT b.nilai_awal FROM atribut b WHERE b.kode = 'A3' AND b.urut = 1) AND a.jumlah_riwayat <= (SELECT b.nilai_akhir FROM atribut b WHERE b.kode = 'A3' AND b.urut = 1),'TIDAK PERNAH',
                        IF(a.jumlah_riwayat >= (SELECT b.nilai_awal FROM atribut b WHERE b.kode = 'A3' AND b.urut = 2) AND a.jumlah_riwayat <= (SELECT b.nilai_akhir FROM atribut b WHERE b.kode = 'A3' AND b.urut = 2),'PERNAH','SERING'))) as label_riwayat,


                    (SELECT 
                    IF(a.rekomendasi >= (SELECT b.nilai_awal FROM atribut b WHERE b.kode = 'XX' AND b.urut = 1) AND a.rekomendasi <= (SELECT b.nilai_akhir FROM atribut b WHERE b.kode = 'XX' AND b.urut = 1),'DISARANKAN','REKOMENDASI')) as rekomendasi

                    FROM naive_bayes_training_data as a
                ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW TrainingNassamiView");
    }
};
