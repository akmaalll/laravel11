<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TitleSimilarityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function checkTitleSimilarity(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'judul' => 'required|string|min:10|max:500'
            ]);

            $inputTitle = $request->input('judul');

            // Ambil semua judul dari database
            $existingTitles = DB::table('mst_juduls')
                ->select('id', 'judul', 'created_at')
                ->get();
            // dd($existingTitles);
            if ($existingTitles->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'similarity' => 0,
                    'message' => 'Tidak ada judul pembanding di database',
                    'similar_titles' => []
                ]);
            }

            // Hitung similarity untuk setiap judul
            $similarities = [];
            foreach ($existingTitles as $existingTitle) {
                // dd($existingTitle);
                $similarity = $this->calculateCosineSimilarity($inputTitle, $existingTitle->judul);
                dd($similarity);

                if ($similarity > 0.1) { // Hanya simpan yang similarity > 10%
                    $similarities[] = [
                        'id' => $existingTitle->id,
                        'judul' => $existingTitle->judul,
                        'similarity' => $similarity,
                        'created_at' => $existingTitle->created_at
                    ];
                }
            }

            // Urutkan berdasarkan similarity tertinggi
            usort($similarities, function ($a, $b) {
                return $b['similarity'] <=> $a['similarity'];
            });

            // Ambil similarity tertinggi
            $maxSimilarity = !empty($similarities) ? $similarities[0]['similarity'] : 0;

            // Ambil 5 judul teratas yang mirip untuk ditampilkan
            $topSimilarTitles = array_slice($similarities, 0, 5);

            return response()->json([
                'success' => true,
                'similarity' => $maxSimilarity,
                'similar_titles' => $topSimilarTitles,
                'total_compared' => $existingTitles->count(),
                'message' => $this->getSimilarityMessage($maxSimilarity)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in checkTitleSimilarity: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Calculate cosine similarity between two texts
     */
    private function calculateCosineSimilarity($text1, $text2)
    {
        // Preprocessing teks
        $text1 = $this->preprocessText($text1);
        $text2 = $this->preprocessText($text2);

        // Tokenisasi
        $tokens1 = $this->tokenize($text1);
        $tokens2 = $this->tokenize($text2);

        // Buat vocabulary dari kedua teks
        $vocabulary = array_unique(array_merge($tokens1, $tokens2));

        // Hitung term frequency untuk setiap teks
        $vector1 = $this->getTermFrequencyVector($tokens1, $vocabulary);
        $vector2 = $this->getTermFrequencyVector($tokens2, $vocabulary);

        // Hitung cosine similarity
        return $this->cosineSimilarity($vector1, $vector2);
    }

    /**
     * Preprocess text (lowercase, remove punctuation, etc.)
     */
    private function preprocessText($text)
    {
        // Convert to lowercase
        $text = strtolower($text);

        // Remove punctuation and special characters
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);

        // Remove extra whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    /**
     * Tokenize text into words
     */
    private function tokenize($text)
    {
        // Split by whitespace and remove empty tokens
        $tokens = array_filter(explode(' ', $text), function ($token) {
            return !empty(trim($token));
        });

        // Remove stopwords (kata-kata umum yang tidak bermakna)
        $stopwords = [
            'yang',
            'dan',
            'di',
            'ke',
            'dari',
            'untuk',
            'dengan',
            'pada',
            'dalam',
            'oleh',
            'sebagai',
            'adalah',
            'akan',
            'telah',
            'dapat',
            'atau',
            'juga',
            'tidak',
            'ada',
            'ini',
            'itu',
            'nya',
            'an',
            'al',
            'el',
            'la',
            'le',
            'de',
            'du',
            'the',
            'of',
            'and',
            'or',
            'in',
            'on',
            'at',
            'by',
            'for',
            'with',
            'to',
            'from',
            'as',
            'is',
            'are',
            'was',
            'were',
            'be',
            'been',
            'have',
            'has',
            'had',
            'do',
            'does',
            'did',
            'will',
            'would',
            'could',
            'should',
            'may',
            'might',
            'can',
            'must',
            'shall'
        ];

        return array_filter($tokens, function ($token) use ($stopwords) {
            return !in_array($token, $stopwords) && strlen($token) > 2;
        });
    }

    /**
     * Get term frequency vector for given tokens and vocabulary
     */
    private function getTermFrequencyVector($tokens, $vocabulary)
    {
        $vector = [];
        $tokenCounts = array_count_values($tokens);

        foreach ($vocabulary as $term) {
            $vector[] = isset($tokenCounts[$term]) ? $tokenCounts[$term] : 0;
        }

        return $vector;
    }

    /**
     * Calculate cosine similarity between two vectors
     */
    private function cosineSimilarity($vector1, $vector2)
    {
        // Hitung dot product
        $dotProduct = 0;
        for ($i = 0; $i < count($vector1); $i++) {
            $dotProduct += $vector1[$i] * $vector2[$i];
        }

        // Hitung magnitude untuk vector1
        $magnitude1 = sqrt(array_sum(array_map(function ($x) {
            return $x * $x;
        }, $vector1)));

        // Hitung magnitude untuk vector2
        $magnitude2 = sqrt(array_sum(array_map(function ($x) {
            return $x * $x;
        }, $vector2)));

        // Avoid division by zero
        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        return $dotProduct / ($magnitude1 * $magnitude2);
    }

    /**
     * Get similarity message based on percentage
     */
    private function getSimilarityMessage($similarity)
    {
        $percentage = $similarity * 100;

        if ($percentage < 30) {
            return 'Tingkat kesamaan rendah. Judul dapat digunakan.';
        } elseif ($percentage < 70) {
            return 'Tingkat kesamaan sedang. Disarankan untuk memodifikasi judul.';
        } else {
            return 'Tingkat kesamaan tinggi. Judul tidak dapat digunakan.';
        }
    }

    /**
     * Advanced similarity with weighted terms (opsional)
     */
    private function calculateAdvancedSimilarity($text1, $text2)
    {
        // Implementasi TF-IDF untuk similarity yang lebih akurat
        $text1 = $this->preprocessText($text1);
        $text2 = $this->preprocessText($text2);

        $tokens1 = $this->tokenize($text1);
        $tokens2 = $this->tokenize($text2);

        // Hitung TF-IDF scores
        $tfidf1 = $this->calculateTFIDF($tokens1);
        $tfidf2 = $this->calculateTFIDF($tokens2);

        // Hitung similarity menggunakan TF-IDF vectors
        return $this->tfidfCosineSimilarity($tfidf1, $tfidf2);
    }

    /**
     * Calculate TF-IDF scores
     */
    private function calculateTFIDF($tokens)
    {
        // Simplified TF-IDF implementation
        $termFreq = array_count_values($tokens);
        $totalTerms = count($tokens);

        $tfidf = [];
        foreach ($termFreq as $term => $freq) {
            $tf = $freq / $totalTerms;
            // Simplified IDF (would need document corpus for real IDF)
            $idf = log(1 + (1 / $freq));
            $tfidf[$term] = $tf * $idf;
        }

        return $tfidf;
    }

    /**
     * Cosine similarity for TF-IDF vectors
     */
    private function tfidfCosineSimilarity($tfidf1, $tfidf2)
    {
        $allTerms = array_unique(array_merge(array_keys($tfidf1), array_keys($tfidf2)));

        $vector1 = [];
        $vector2 = [];

        foreach ($allTerms as $term) {
            $vector1[] = isset($tfidf1[$term]) ? $tfidf1[$term] : 0;
            $vector2[] = isset($tfidf2[$term]) ? $tfidf2[$term] : 0;
        }

        return $this->cosineSimilarity($vector1, $vector2);
    }
}
