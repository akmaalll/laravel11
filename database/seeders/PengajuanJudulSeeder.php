<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengajuanJudul;
use App\Models\Prodi;
use Illuminate\Support\Str;

class PengajuanJudulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil satu prodi yang ada
        $prodi = Prodi::first();
        if (!$prodi) {
            $this->command->warn('Tidak ada data prodi. Seeder PengajuanJudulSeeder dilewati.');
            return;
        }

        $data = [
            [
                'id' => (string) Str::uuid(),
                'id_prodi' => $prodi->id,
                'judul' => 'Sistem Informasi Pengajuan Judul Skripsi',
                'topik' => 'Web Development',
                'konsentrasi' => 'Sistem Informasi',
                'objek_penelitian' => 'Mahasiswa',
                'latar_belakang' => 'Permasalahan pengajuan judul secara manual.',
                'rumusan_masalah' => 'Bagaimana membangun sistem pengajuan judul?',
                'tujuan_penelitian' => 'Membuat aplikasi pengajuan judul online.',
                'penelitian_terkait' => 'Penelitian sistem informasi pengajuan judul.',
                'status' => 'diajukan',
            ],
            [
                'id' => (string) Str::uuid(),
                'id_prodi' => $prodi->id,
                'judul' => 'Implementasi Algoritma K-Means untuk Clustering Data',
                'topik' => 'Machine Learning',
                'konsentrasi' => 'Data Mining',
                'objek_penelitian' => 'Data Mahasiswa',
                'latar_belakang' => 'Banyak data belum terkelompok optimal.',
                'rumusan_masalah' => 'Bagaimana mengelompokkan data dengan K-Means?',
                'tujuan_penelitian' => 'Mengelompokkan data mahasiswa.',
                'penelitian_terkait' => 'Penelitian clustering data.',
                'status' => 'diajukan',
            ],
            [
                'id' => (string) Str::uuid(),
                'id_prodi' => $prodi->id,
                'judul' => 'Aplikasi Mobile untuk Sistem Informasi Akademik',
                'topik' => 'Mobile Development',
                'konsentrasi' => 'Aplikasi Mobile',
                'objek_penelitian' => 'Mahasiswa',
                'latar_belakang' => 'Kebutuhan akses akademik via mobile.',
                'rumusan_masalah' => 'Bagaimana membangun aplikasi mobile akademik?',
                'tujuan_penelitian' => 'Membuat aplikasi mobile akademik.',
                'penelitian_terkait' => 'Penelitian aplikasi mobile.',
                'status' => 'diajukan',
            ],
        ];

        foreach ($data as $item) {
            PengajuanJudul::create($item);
        }

        $this->command->info('Sample data pengajuan judul berhasil ditambahkan!');
    }
}
