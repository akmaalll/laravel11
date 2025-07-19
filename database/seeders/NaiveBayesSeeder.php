<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\DosenMataKuliah;
use App\Models\DosenPenelitian;
use App\Models\NaiveBayesTrainingData;

class NaiveBayesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data untuk testing Naive Bayes

        // 1. Sample Mata Kuliah Dosen
        $mataKuliahData = [
            ['dosen_nidn' => '0012345678', 'mata_kuliah' => 'Pemrograman Web', 'kode_mk' => 'IF101', 'sks' => 3],
            ['dosen_nidn' => '0012345678', 'mata_kuliah' => 'Database Management', 'kode_mk' => 'IF102', 'sks' => 3],
            ['dosen_nidn' => '0012345679', 'mata_kuliah' => 'Machine Learning', 'kode_mk' => 'IF201', 'sks' => 3],
            ['dosen_nidn' => '0012345679', 'mata_kuliah' => 'Artificial Intelligence', 'kode_mk' => 'IF202', 'sks' => 3],
            ['dosen_nidn' => '0012345680', 'mata_kuliah' => 'Mobile Development', 'kode_mk' => 'IF301', 'sks' => 3],
            ['dosen_nidn' => '0012345680', 'mata_kuliah' => 'Software Engineering', 'kode_mk' => 'IF302', 'sks' => 3],
        ];

        foreach ($mataKuliahData as $data) {
            DosenMataKuliah::create($data);
        }

        // 2. Sample Penelitian Dosen
        $penelitianData = [
            [
                'dosen_nidn' => '0012345678',
                'judul_penelitian' => 'Sistem Informasi Akademik Berbasis Web',
                'topik_penelitian' => 'Web Development, Database, Sistem Informasi',
                'jenis_penelitian' => 'Terapan',
                'tahun_penelitian' => 2023,
                'status' => 'selesai'
            ],
            [
                'dosen_nidn' => '0012345679',
                'judul_penelitian' => 'Implementasi Algoritma Naive Bayes untuk Klasifikasi Teks',
                'topik_penelitian' => 'Machine Learning, Natural Language Processing, Naive Bayes',
                'jenis_penelitian' => 'Dasar',
                'tahun_penelitian' => 2023,
                'status' => 'selesai'
            ],
            [
                'dosen_nidn' => '0012345680',
                'judul_penelitian' => 'Pengembangan Aplikasi Mobile untuk E-Commerce',
                'topik_penelitian' => 'Mobile Development, E-Commerce, User Experience',
                'jenis_penelitian' => 'Pengembangan',
                'tahun_penelitian' => 2023,
                'status' => 'selesai'
            ],
        ];

        foreach ($penelitianData as $data) {
            DosenPenelitian::create($data);
        }

        // 3. Sample Training Data
        $trainingData = [
            [
                'pengajuan_id' => 'sample-001',
                'dosen_nidn' => '0012345678',
                'judul_skripsi' => 'Sistem Informasi Pengajuan Judul Skripsi',
                'topik_skripsi' => 'Web Development',
                'keahlian_dosen' => json_encode(['Web Development', 'Database']),
                'mata_kuliah_dosen' => json_encode(['Pemrograman Web', 'Database Management']),
                'history_bimbingan' => json_encode(['Web Development', 'Database']),
                'history_penelitian' => json_encode(['Web Development, Database, Sistem Informasi']),
                'hasil_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.75
            ],
            [
                'pengajuan_id' => 'sample-002',
                'dosen_nidn' => '0012345679',
                'judul_skripsi' => 'Implementasi Algoritma K-Means untuk Clustering Data',
                'topik_skripsi' => 'Machine Learning',
                'keahlian_dosen' => json_encode(['Machine Learning', 'Data Mining']),
                'mata_kuliah_dosen' => json_encode(['Machine Learning', 'Artificial Intelligence']),
                'history_bimbingan' => json_encode(['Machine Learning', 'Data Mining']),
                'history_penelitian' => json_encode(['Machine Learning, Natural Language Processing, Naive Bayes']),
                'hasil_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.80
            ],
            [
                'pengajuan_id' => 'sample-003',
                'dosen_nidn' => '0012345680',
                'judul_skripsi' => 'Aplikasi Mobile untuk Sistem Informasi Akademik',
                'topik_skripsi' => 'Mobile Development',
                'keahlian_dosen' => json_encode(['Mobile Development', 'User Experience']),
                'mata_kuliah_dosen' => json_encode(['Mobile Development', 'Software Engineering']),
                'history_bimbingan' => json_encode(['Mobile Development', 'User Experience']),
                'history_penelitian' => json_encode(['Mobile Development, E-Commerce, User Experience']),
                'hasil_pembimbingan' => 'berhasil',
                'nilai_skripsi' => 3.70
            ],
        ];

        foreach ($trainingData as $data) {
            NaiveBayesTrainingData::create($data);
        }

        $this->command->info('Sample data for Naive Bayes has been seeded successfully!');
    }
}
