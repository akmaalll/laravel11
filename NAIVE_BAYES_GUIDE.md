# 🧠 Panduan Sistem Rekomendasi Pembimbing dengan Naive Bayes

## 📋 Overview

Sistem ini menggunakan algoritma **Naive Bayes** dengan **3 atribut** untuk memberikan rekomendasi dosen pembimbing berdasarkan:

1. **Keahlian Dosen** (40% weight) - Mata kuliah yang diajarkan
2. **History Bimbingan** (40% weight) - Topik judul yang pernah dibimbingi
3. **History Penelitian** (20% weight) - Topik penelitian dosen

## 🚀 Setup & Installation

### 1. Jalankan Migration

```bash
php artisan migrate
```

### 2. Seed Data Sample

```bash
php artisan db:seed --class=NaiveBayesSeeder
```

### 3. Train Model

```bash
php artisan naive-bayes:train
```

## 🎯 Cara Penggunaan

### **A. Halaman Assignment Pembimbing (Admin)**

**URL:** `/admin/pembimbing/assignment`

**Fitur:**

-   ✅ Pilih pengajuan judul yang sudah diverifikasi
-   ✅ Dapatkan rekomendasi AI secara real-time
-   ✅ Lihat detail 3 atribut untuk setiap rekomendasi
-   ✅ Admin tetap yang menentukan pembimbing akhir
-   ✅ Assignment otomatis ke database

**Workflow:**

1. Pilih pengajuan judul dari dropdown
2. Klik "Dapatkan Rekomendasi"
3. Review rekomendasi AI dengan score dan atribut
4. Pilih pembimbing 1 & 2 (bisa dari rekomendasi atau manual)
5. Klik "Assign Pembimbing"

### **B. Halaman Test (Development)**

**URL:** `/admin/pembimbing/naive-bayes-test`

**Fitur:**

-   ✅ Testing rekomendasi tanpa assignment
-   ✅ Melihat detail algoritma
-   ✅ Training model manual

### **C. API Endpoints**

```bash
# Get recommendations
GET /admin/pembimbing/recommendation-naive-bayes/{pengajuanId}

# Train model
POST /admin/pembimbing/train-naive-bayes

# Save training data
POST /admin/pembimbing/save-training-data
```

## 📊 Struktur Database

### **Tabel Baru:**

1. **`dosen_mata_kuliah`** - Mata kuliah yang diajarkan dosen
2. **`dosen_penelitian`** - History penelitian dosen
3. **`naive_bayes_training_data`** - Data training untuk ML

### **Model Baru:**

1. **`DosenMataKuliah`** - Model untuk mata kuliah dosen
2. **`DosenPenelitian`** - Model untuk penelitian dosen
3. **`NaiveBayesTrainingData`** - Model untuk data training

## 🧮 Algoritma Naive Bayes

### **Formula Score:**

```
Total Score = (Keahlian Score × 0.4) + (Bimbingan Score × 0.4) + (Penelitian Score × 0.2)
```

### **Perhitungan Per Atribut:**

#### **1. Keahlian Score (40%)**

-   Menggunakan **Jaccard Similarity**
-   Membandingkan keahlian dosen vs topik judul
-   Score tertinggi dari semua keahlian dosen

#### **2. History Bimbingan Score (40%)**

-   Menggunakan **Cosine Similarity**
-   Membandingkan history bimbingan vs judul/topik
-   Weight: 70% topic similarity + 30% judul similarity

#### **3. History Penelitian Score (20%)**

-   Menggunakan **Cosine Similarity**
-   Membandingkan history penelitian vs judul/topik
-   Weight: 60% topic similarity + 40% judul similarity

## 🔧 Maintenance

### **Menambah Data Training:**

```php
// Otomatis saat assignment berhasil
$naiveBayesService->saveTrainingData($pengajuanId, $dosenNidn, 'berhasil');

// Manual via API
POST /admin/pembimbing/save-training-data
{
    "pengajuan_id": "uuid",
    "dosen_nidn": "1234567890",
    "hasil_pembimbingan": "berhasil"
}
```

### **Retrain Model:**

```bash
# Retrain dengan data baru
php artisan naive-bayes:train --force
```

### **Monitoring:**

```bash
# Cek status training data
php artisan tinker
>>> App\Models\NaiveBayesTrainingData::count()
>>> App\Models\NaiveBayesTrainingData::where('hasil_pembimbingan', 'berhasil')->count()
```

## 🎨 UI/UX Features

### **Assignment Page:**

-   🎯 **Smart Recommendations** - Top 5 rekomendasi dengan score
-   📊 **Visual Score Display** - Persentase kecocokan
-   🔍 **Detailed Attributes** - Lihat 3 atribut per dosen
-   ⚡ **One-Click Selection** - Pilih dari rekomendasi atau manual
-   📝 **Assignment Notes** - Catatan tambahan untuk admin

### **Recommendation Cards:**

-   🏆 **Top Choice Badge** - Highlight rekomendasi terbaik
-   📈 **Score Visualization** - Progress bar dan persentase
-   📋 **Attribute Breakdown** - Detail keahlian, mata kuliah, history
-   🎯 **Quick Select** - Tombol pilih langsung

## 🔒 Security & Validation

### **Input Validation:**

-   ✅ Pengajuan harus ada dan valid
-   ✅ Dosen harus ada di database
-   ✅ Pembimbing 1 & 2 tidak boleh sama
-   ✅ Status pengajuan harus sesuai

### **Error Handling:**

-   🚫 Tidak ada data training
-   🚫 Dosen tidak ditemukan
-   🚫 Pengajuan sudah memiliki pembimbing
-   🚫 Model training gagal

## 📈 Performance Optimization

### **Caching:**

-   Model training results
-   Dosen attributes
-   Recommendation calculations

### **Database Indexing:**

-   `dosen_nidn` pada semua tabel
-   `topik_penelitian` untuk similarity search
-   `hasil_pembimbingan` untuk filtering

## 🚨 Troubleshooting

### **Common Issues:**

1. **"Tidak ada data training"**

    ```bash
    php artisan db:seed --class=NaiveBayesSeeder
    php artisan naive-bayes:train
    ```

2. **"Model training gagal"**

    - Cek PHP-ML library terinstall
    - Pastikan ada data training yang valid
    - Cek log error di `storage/logs/laravel.log`

3. **"Rekomendasi tidak akurat"**
    - Tambah lebih banyak data training
    - Retrain model dengan data baru
    - Review weight atribut (0.4, 0.4, 0.2)

### **Debug Mode:**

```php
// Di NaiveBayesService
Log::debug('Training data:', $trainingData->toArray());
Log::debug('Recommendation scores:', $dosenScores);
```

## 🎯 Best Practices

### **Data Quality:**

-   ✅ Pastikan keahlian dosen akurat
-   ✅ Update history bimbingan secara berkala
-   ✅ Masukkan data penelitian dosen
-   ✅ Validasi hasil pembimbingan

### **Model Maintenance:**

-   🔄 Retrain model setiap 3 bulan
-   📊 Monitor accuracy rekomendasi
-   🎯 Adjust weight berdasarkan feedback
-   📈 Tambah data training berkala

### **User Experience:**

-   🎨 Tampilkan loading saat processing
-   📊 Berikan feedback yang jelas
-   🔄 Allow manual override rekomendasi
-   📝 Simpan log assignment untuk audit

## 📞 Support

Untuk bantuan teknis atau pertanyaan:

-   📧 Email: support@example.com
-   📱 WhatsApp: +62-xxx-xxx-xxxx
-   📖 Documentation: `/docs/naive-bayes`

---

**Version:** 1.0.0  
**Last Updated:** January 2025  
**Author:** AI Assistant
