<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DosenMatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::transaction(function () {
            $csvFile = public_path('data_matkul_fix.csv'); // Sesuaikan path

            if (!File::exists($csvFile)) {
                $this->command->error("File CSV tidak ditemukan!");
                return;
            }

            $file = fopen($csvFile, 'r');
            fgetcsv($file, 0, ';'); // Skip header

            while (($row = fgetcsv($file, 0, ';')) !== false) {
                $nidn = $row[0];
                $mataKuliah = $row[1];
                $kodeMk = $row[2] ?? null;
                $semester = $row[3] ?? null;

                // Cek apakah dosen ada di mst_dosens
                $dosenExists = DB::table('mst_dosens')->where('nidn', $nidn)->exists();

                if (!$dosenExists) {
                    // Insert dosen baru dengan data minimal
                    DB::table('mst_dosens')->insert([
                        'nidn' => $nidn,
                        'nama' => 'Dosen ' . $nidn,
                        'email' => 'dosen' . $nidn . '@example.com',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }   

                // Insert data mata kuliah
                DB::table('dosen_mata_kuliah')->insert([
                    'dosen_nidn' => $nidn,
                    'mata_kuliah' => $mataKuliah,
                    'kode_mk' => $kodeMk,
                    'semester' => $semester,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            fclose($file);
            $this->command->info('Data berhasil diimpor!');
        });
    }
}
