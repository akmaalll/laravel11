<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Judul;
use App\Models\Prodi;
use App\Models\User;

class MstJudulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil satu prodi yang ada
        $prodi = Prodi::first();
        if (!$prodi) {
            $this->command->warn('Tidak ada data prodi. Seeder MstJudulSeeder dilewati.');
            return;
        }

        // Ambil satu user yang ada
        $user = User::first();
        if (!$user) {
            $this->command->warn('Tidak ada data user. Seeder MstJudulSeeder dilewati.');
            return;
        }

        // Data dari CSV file
        $csvData = [
            ['judul' => 'PERANCANGAN APLIKASI WATERMARKING KEPEMILIKAN CITRA MENGGUNAKAN KOMBINASI METODE SHA DAN LEAST SIGNIFICANT BIT (LSB)', 'topik' => 'Keamanan Komputer dan Informasi'],
            ['judul' => 'APLIKASI SISTEM PAKAR MENDIAGNOSA PENYAKIT TUBERKULOSIS MENGGUNAKAN METODE CERTAINTY FACTOR BERBASIS ANDROID', 'topik' => 'Artificial Intelligence'],
            ['judul' => 'PERANCANGAN SISTEM INFORMASI PEMBERIAN BANTUAN TERNAK BERBASIS WEB PADA DINAS PETERNAKAN DAN KESEHATAN HEWAN PRO. SULSEL', 'topik' => 'Sistem Terdistribusi (Web Service)'],
            ['judul' => 'PERANCANGAN APLIKASI PERKIRAAN PAJAK KENDARAAN BERMOTOR, KREDIT DAN HARGA JUAL KEMBALI MENGGUNAKAN METODE ARIMA', 'topik' => 'Intelligent System and Control/IoT'],
            ['judul' => 'IMPLEMENTASI ALGORITMA C4.5 UNTUK PEMILIHAN PERGURUAN TINGGI DIMAKASSAR', 'topik' => 'Data Mining'],
            ['judul' => 'ANALISIS PERANCANGAN APLIKASI REAL TIME OBJECT DETECTION ANDROID MENGGUNAKAN TENSORFLOW', 'topik' => 'Artificial Intelligence'],
            ['judul' => 'PERANCANGAN SISTEM INFORMASI PENEBUSAN RESEP OBAT PADA RUMAH SAKIT KE APOTEK BERBASIS WEB', 'topik' => 'Sistem Terdistribusi (Web Service)'],
            ['judul' => 'IMPLEMENTASI EARLY WARNING SYSTEM UNTUK MONITORING JARINGAN MENGGUNAKAN NOTIFIKASI TELEGRAM', 'topik' => 'Perancangan dan Optimasi Jaringan Komputer'],
            ['judul' => 'PERANCANGAN APLIKASI ANALISIS LOYALITAS PELANGGAN PT PLN (PERSERO) ULP MAROS DENGAN METODE K-MEANS CLUSTERING BERBASIS PWA', 'topik' => 'Artificial Intelligence'],
            ['judul' => 'IMPLEMENTASI KOMBINASI ALGORITMA HILL CIPHER DAN CIPHER BLOCK CHAINING DALAM PENGAMANAN TEKS PADA FILE MICROSOFT WORD (.DOC)', 'topik' => 'Keamanan Komputer dan Informasi'],
            ['judul' => 'PERANCANGAN APLIKASI PENTERJEMAH BAHASA MAKASSAR KE BAHASA INDONESIA DISERTAI BENTUK AKSARA LONTARA MENGGUNAKAN METODE BSu BERBASIS WEB', 'topik' => 'Artificial Intelligence'],
            ['judul' => 'APLIKASI SISTEM PAKAR DIAGNOSA HAMA PENYAKIT DAN PENANGANANNYA PADA TANAMAN PADI MENGGUNAKAN METODE CERTAINTY FACTOR', 'topik' => 'Intelligent System and Control/IoT'],
            ['judul' => 'PERANCANGAN APLIKASI MANAJEMEN KEUANGAN PADA MASJID NURUL ILMI BERBASIS WEB', 'topik' => 'Optimasi Database'],
            ['judul' => 'ANALISA LOKASI LAYANAN KESEHATAN DENGAN METODE PUSAT GRAFITASI DI KOTA MAKASSAR', 'topik' => 'Artificial Intelligence'],
            ['judul' => 'RANCANG BANGUN ALAT PENGUKUR GETARAN BANGUNAN SEBAGAI PERINGATAN DINI TERHADAP GEMPA BUMI BERBASIS ARDUINO', 'topik' => 'Intelligent System and Control/IoT'],
            ['judul' => 'PERANCANGAN APLIKASI PERMOHONAN DAN PEMBERIAN KREDIT MENGGUNAKAN METODE WEIGHT PRODUCT PADA PT OTO MULITARTHA MAKASSAR', 'topik' => 'Sistem Pendukung Keputusan'],
            ['judul' => 'SISTEM PENDUKUNG KEPUTUSAN UNTUK MENENTUKAN PENERIMA BANTUAN SOSIAL TAHUNAN DENGAN METODE VIKOR', 'topik' => 'Sistem Pendukung Keputusan'],
            ['judul' => 'PENERAPAN DATA MINING PREDIKSI PENJUALAN MOTOR DENGAN METODE K-NEAREST NEIGHBOR PADA REMAJA MOTOR (HONDA)', 'topik' => 'Data Mining'],
            ['judul' => 'PERANCANGAN APLIKASI SISTEM INFORMASI PENDAYAGUNAAN UNTUK SOP BERKAS PADA KANTOR KPKNL MAKASSAR BERBASIS ANDROID', 'topik' => 'E-Bisnis'],
            ['judul' => 'PERANCANGAN APLIKASI RENTAL BUKU PADA TAMAN BACAAN MAITOBA BERBASIS WEB INTERAKTIF', 'topik' => 'Sistem Terdistribusi (Web Service)'],
            ['judul' => 'SISTEM PENDUKUNG KEPUTUSAN PENENTUAN MASA TANAM IDEAL JAGUNG MENGGUNAKAN METODE Naive Bayes', 'topik' => 'Sistem Pendukung Keputusan'],
            ['judul' => 'Aplikasi Pelayanan Manajemen Gereja Pada Gereja Katolik Paroki Santo Paulus BerbasisMobile', 'topik' => 'E-Bisnis'],
            ['judul' => 'PENGEMBANGAN MONITORING DIGITAL AKTIVITAS KEGIATAN KKLP DAN PENGAJUAN SKRIPSI MAHASISWA PADA STMIK DIPANEGARA BERBASIS MOBILE', 'topik' => 'Data Analyst'],
            ['judul' => 'PENERAPAN METODE MOORA UNTUK PENENTUAN SAYUR DAN BUAH TERBAIK PADA CARREFOUR MAKASSAR', 'topik' => 'Sistem Pendukung Keputusan'],
            ['judul' => 'SISTEM ANALISIS POLA PERSEBARAN COVID-19 MENGGUNAKAN METODE INDEKS MORAN DAN GEARY\'S C', 'topik' => 'Data Mining'],
        ];

        $data = [];
        foreach ($csvData as $item) {
            $data[] = [
                'judul' => $item['judul'],
                'topik' => $item['topik'],
                'id_prodi' => $prodi->id,
                'id_user' => $user->id,
            ];
        }

        foreach ($data as $item) {
            Judul::create($item);
        }

        $this->command->info('Sample data mst_juduls berhasil ditambahkan!');
    }
}
