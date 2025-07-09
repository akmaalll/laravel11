<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TitleClassificationController extends Controller
{
    // Fungsi untuk memproses teks
    private function preprocessText($text)
    {
        // Konversi ke huruf kecil
        $text = strtolower($text);
        // Hapus karakter khusus dan spasi berlebih
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    // Fungsi untuk menghitung TF-IDF
    private function calculateTFIDF($text, $documents)
    {
        $words = explode(' ', $text);
        $tf = array_count_values($words);
        $tfidf = [];

        $N = count($documents); // Jumlah total dokumen

        foreach ($tf as $word => $freq) {
            // Hitung frekuensi dokumen (df)
            $df = 0;
            foreach ($documents as $doc) {
                if (strpos($doc, $word) !== false) {
                    $df++;
                }
            }

            // Hitung IDF
            $idf = log($N / ($df + 1));

            // Hitung TF-IDF
            $tfidf[$word] = $freq * $idf;
        }

        return $tfidf;
    }

    // Fungsi untuk menghitung cosine similarity
    private function cosineSimilarity($vector1, $vector2)
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        $allWords = array_unique(array_merge(array_keys($vector1), array_keys($vector2)));
        
        foreach ($allWords as $word) {
            $val1 = $vector1[$word] ?? 0;
            $val2 = $vector2[$word] ?? 0;
            
            $dotProduct += $val1 * $val2;
            $magnitude1 += $val1 * $val1;
            $magnitude2 += $val2 * $val2;
        }

        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        return $dotProduct / ($magnitude1 * $magnitude2);
    }

    public function checkTitleSimilarity(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|min:10'
        ]);

        $input_title = $request->judul;
        $preprocessed_title = $this->preprocessText($input_title);

        // Dapatkan ID prodi pengguna saat ini
        $id_prodi = Session::get('id_prodi') ?? 2; // Fallback untuk testing

        // Dapatkan data judul dari database
        $existingTitles = DB::table('mst_juduls')
            ->select('id', 'judul', 'topik', 'created_at')
            ->where('id_prodi', $id_prodi)
            ->get();

        if ($existingTitles->isEmpty()) {
            return response()->json([
                'success' => true,
                'similarity' => 0,
                'message' => 'Tidak ada judul pembanding di database',
                'similar_titles' => [],
                'predicted_topic' => null,
                'validation_message' => 'Belum ada data referensi untuk program studi ini'
            ]);
        }

        // Hitung similarity dengan semua judul yang ada
        $documents = [];
        $similarities = [];
        $training_data_array = [];

        foreach ($existingTitles as $existingTitle) {
            $preprocessed_doc = $this->preprocessText($existingTitle->judul);
            $documents[] = $preprocessed_doc;
            $training_data_array[] = [
                'text' => $preprocessed_doc,
                'topic' => $existingTitle->topik
            ];
        }

        // Hitung TF-IDF untuk judul input
        $input_tfidf = $this->calculateTFIDF($preprocessed_title, $documents);

        // Hitung similarity untuk setiap judul
        $max_similarity = -1;
        $predicted_topic = null;
        $similarity_results = [];

        foreach ($training_data_array as $index => $train_doc) {
            $doc_tfidf = $this->calculateTFIDF($train_doc['text'], $documents);
            $similarity = $this->cosineSimilarity($input_tfidf, $doc_tfidf);

            if ($similarity > 0.1) { // Hanya simpan yang similarity > 10%
                $similarity_results[] = [
                    'id' => $existingTitles[$index]->id,
                    'judul' => $existingTitles[$index]->judul,
                    'topik' => $existingTitles[$index]->topik,
                    'similarity' => $similarity,
                    'created_at' => $existingTitles[$index]->created_at
                ];

                if ($similarity > $max_similarity) {
                    $max_similarity = $similarity;
                    $predicted_topic = $train_doc['topic'];
                }
            }
        }

        // Urutkan berdasarkan similarity tertinggi
        usort($similarity_results, function ($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        // Ambil 5 judul teratas yang mirip
        $top_similar_titles = array_slice($similarity_results, 0, 5);

        // Validasi topik
        if ($max_similarity <= 0.0) {
            $topic_validasi = 'Hasil Klasifikasi Tidak Terdeteksi';
            return response()->json([
                'status' => 'warning',
                'message' => $topic_validasi,
                'similarity' => 0,
                'similar_titles' => $top_similar_titles,
                'predicted_topic' => null,
                'validation_message' => $topic_validasi
            ]);
        } else {
            // Periksa apakah topik yang diprediksi ada di prodi saat ini
            $topic_exists = DB::table('mst_juduls')
                ->where('id_prodi', $id_prodi)
                ->where('topik', $predicted_topic)
                ->exists();

            if ($topic_exists) {
                $topic_validasi = "";
                $status = 'success';
                $message = 'Judul dapat digunakan';
            } else {
                $topic_validasi = 'Hasil Klasifikasi Judul Anda Tidak Sesuai Dengan Topik pada Program Studi ' . Session::get('prodi');
                $status = 'warning';
                $message = 'Topik tidak sesuai dengan program studi';
            }

            return response()->json([
                'status' => $status,
                'message' => $message,
                'similarity' => $max_similarity,
                'similar_titles' => $top_similar_titles,
                'predicted_topic' => $predicted_topic,
                'validation_message' => $topic_validasi,
                'input_title' => $input_title
            ]);
        }
    }
}
