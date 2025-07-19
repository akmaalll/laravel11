<?php

namespace App\Services;

use App\Models\Dosen;
use App\Models\NaiveBayesTrainingData;
use Phpml\Classification\NaiveBayes;
use Phpml\FeatureExtraction\TfidfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;
use Illuminate\Support\Facades\Log;

class NaiveBayesService
{
    private $classifier;
    private $vectorizer;
    private $tfidf;
    private $tokenizer;

    public function __construct()
    {
        $this->tokenizer = new WordTokenizer();
        $this->vectorizer = new TokenCountVectorizer($this->tokenizer);
        $this->tfidf = new TfidfTransformer();
        $this->classifier = new NaiveBayes();
    }

    /**
     * Train the Naive Bayes model with 3 attributes
     */
    public function trainModel()
    {
        try {
            // Get training data
            $trainingData = NaiveBayesTrainingData::getTrainingData();

            if ($trainingData->isEmpty()) {
                throw new \Exception('Tidak ada data training yang tersedia');
            }

            $samples = [];
            $labels = [];

            foreach ($trainingData as $data) {
                // Combine 3 attributes into one feature vector
                $features = $this->combineAttributes($data);
                $samples[] = $features;
                $labels[] = $data->dosen_nidn;
            }

            // Vectorize and apply TF-IDF
            $this->vectorizer->fit($samples);
            $vectorizedSamples = $this->vectorizer->transform($samples);

            $this->tfidf->fit($vectorizedSamples);
            $tfidfSamples = $this->tfidf->transform($vectorizedSamples);

            // Train the classifier
            $this->classifier->train($tfidfSamples, $labels);

            Log::info('Naive Bayes model trained successfully with ' . count($samples) . ' samples');
            return true;
        } catch (\Exception $e) {
            Log::error('Error training Naive Bayes model: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Predict dosen pembimbing using 3 attributes
     */
    public function predictDosenPembimbing($judul, $topik, $konsentrasi, $limit = 5)
    {
        try {
            // Get all available dosens
            $allDosens = Dosen::with(['keahlians', 'mataKuliah', 'penelitian', 'pembimbingan.pengajuanJudul'])->get();

            if ($allDosens->isEmpty()) {
                throw new \Exception('Tidak ada dosen yang tersedia');
            }

            $dosenScores = [];

            foreach ($allDosens as $dosen) {
                $score = $this->calculateNaiveBayesScore($dosen, $judul, $topik, $konsentrasi);

                $dosenScores[] = [
                    'dosen' => $dosen,
                    'score' => $score,
                    'attributes' => $dosen->getNaiveBayesAttributes()
                ];
            }

            // Sort by score (descending)
            usort($dosenScores, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            // Return top N recommendations
            return array_slice($dosenScores, 0, $limit);
        } catch (\Exception $e) {
            Log::error('Error predicting dosen pembimbing: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Calculate Naive Bayes score for a dosen based on 3 attributes
     */
    private function calculateNaiveBayesScore($dosen, $judul, $topik, $konsentrasi)
    {
        $attributes = $dosen->getNaiveBayesAttributes();

        // Attribute 1: Keahlian Dosen (Weight: 0.4)
        $keahlianScore = $this->calculateKeahlianScore($attributes['keahlian'], $topik, $konsentrasi);

        // Attribute 2: History Bimbingan (Weight: 0.4)
        $bimbinganScore = $this->calculateBimbinganScore($attributes['history_bimbingan'], $topik, $judul);

        // Attribute 3: History Penelitian (Weight: 0.2)
        $penelitianScore = $this->calculatePenelitianScore($attributes['history_penelitian'], $topik, $judul);

        // Weighted combination
        $totalScore = ($keahlianScore * 0.4) + ($bimbinganScore * 0.4) + ($penelitianScore * 0.2);

        return $totalScore;
    }

    /**
     * Calculate score based on keahlian dosen
     */
    private function calculateKeahlianScore($keahlians, $topik, $konsentrasi)
    {
        if (empty($keahlians)) {
            return 0;
        }

        $topikWords = $this->preprocessText($topik . ' ' . $konsentrasi);
        $topikArray = explode(' ', $topikWords);

        $maxScore = 0;
        foreach ($keahlians as $keahlian) {
            $keahlianWords = $this->preprocessText($keahlian);
            $keahlianArray = explode(' ', $keahlianWords);

            $similarity = $this->calculateJaccardSimilarity($topikArray, $keahlianArray);
            $maxScore = max($maxScore, $similarity);
        }

        return $maxScore;
    }

    /**
     * Calculate score based on history bimbingan
     */
    private function calculateBimbinganScore($historyBimbingan, $topik, $judul)
    {
        if (empty($historyBimbingan)) {
            return 0;
        }

        $currentTopic = $this->preprocessText($topik);
        $currentJudul = $this->preprocessText($judul);

        $maxScore = 0;
        foreach ($historyBimbingan as $bimbingan) {
            $bimbinganText = $this->preprocessText($bimbingan);

            // Calculate similarity with current topic
            $topicSimilarity = $this->calculateCosineSimilarity(
                $this->textToVector($currentTopic),
                $this->textToVector($bimbinganText)
            );

            // Calculate similarity with current judul
            $judulSimilarity = $this->calculateCosineSimilarity(
                $this->textToVector($currentJudul),
                $this->textToVector($bimbinganText)
            );

            $combinedScore = ($topicSimilarity * 0.7) + ($judulSimilarity * 0.3);
            $maxScore = max($maxScore, $combinedScore);
        }

        return $maxScore;
    }

    /**
     * Calculate score based on history penelitian
     */
    private function calculatePenelitianScore($historyPenelitian, $topik, $judul)
    {
        if (empty($historyPenelitian)) {
            return 0;
        }

        $currentTopic = $this->preprocessText($topik);
        $currentJudul = $this->preprocessText($judul);

        $maxScore = 0;
        foreach ($historyPenelitian as $penelitian) {
            $penelitianText = $this->preprocessText($penelitian);

            // Calculate similarity with current topic
            $topicSimilarity = $this->calculateCosineSimilarity(
                $this->textToVector($currentTopic),
                $this->textToVector($penelitianText)
            );

            // Calculate similarity with current judul
            $judulSimilarity = $this->calculateCosineSimilarity(
                $this->textToVector($currentJudul),
                $this->textToVector($penelitianText)
            );

            $combinedScore = ($topicSimilarity * 0.6) + ($judulSimilarity * 0.4);
            $maxScore = max($maxScore, $combinedScore);
        }

        return $maxScore;
    }

    /**
     * Combine 3 attributes into feature vector
     */
    private function combineAttributes($trainingData)
    {
        $keahlian = implode(' ', $trainingData->keahlian_dosen ?? []);
        $mataKuliah = implode(' ', $trainingData->mata_kuliah_dosen ?? []);
        $bimbingan = implode(' ', $trainingData->history_bimbingan ?? []);
        $penelitian = implode(' ', $trainingData->history_penelitian ?? []);

        return $keahlian . ' ' . $mataKuliah . ' ' . $bimbingan . ' ' . $penelitian;
    }

    /**
     * Calculate Jaccard similarity
     */
    private function calculateJaccardSimilarity($array1, $array2)
    {
        $intersection = array_intersect($array1, $array2);
        $union = array_unique(array_merge($array1, $array2));

        if (empty($union)) {
            return 0;
        }

        return count($intersection) / count($union);
    }

    /**
     * Calculate cosine similarity
     */
    private function calculateCosineSimilarity($vector1, $vector2)
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        for ($i = 0; $i < count($vector1); $i++) {
            $dotProduct += $vector1[$i] * $vector2[$i];
            $magnitude1 += $vector1[$i] * $vector1[$i];
            $magnitude2 += $vector2[$i] * $vector2[$i];
        }

        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        return $dotProduct / ($magnitude1 * $magnitude2);
    }

    /**
     * Convert text to vector
     */
    private function textToVector($text)
    {
        $words = explode(' ', $text);
        $wordCount = array_count_values($words);

        // Create a simple frequency vector
        $uniqueWords = array_unique($words);
        $vector = [];

        foreach ($uniqueWords as $word) {
            $vector[] = $wordCount[$word] ?? 0;
        }

        return $vector;
    }

    /**
     * Preprocess text for analysis
     */
    private function preprocessText($text)
    {
        // Convert to lowercase
        $text = strtolower($text);

        // Remove special characters
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);

        // Remove extra whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        // Trim
        $text = trim($text);

        return $text;
    }

    /**
     * Save training data for future use
     */
    public function saveTrainingData($pengajuanId, $dosenNidn, $hasilPembimbingan = 'berhasil')
    {
        try {
            $pengajuan = \App\Models\PengajuanJudul::find($pengajuanId);
            $dosen = Dosen::find($dosenNidn);

            if (!$pengajuan || !$dosen) {
                throw new \Exception('Data pengajuan atau dosen tidak ditemukan');
            }

            $attributes = $dosen->getNaiveBayesAttributes();

            $trainingData = [
                'pengajuan_id' => $pengajuanId,
                'dosen_nidn' => $dosenNidn,
                'judul_skripsi' => $pengajuan->judul,
                'topik_skripsi' => $pengajuan->topik,
                'keahlian_dosen' => $attributes['keahlian'],
                'mata_kuliah_dosen' => $attributes['mata_kuliah'],
                'history_bimbingan' => $attributes['history_bimbingan'],
                'history_penelitian' => $attributes['history_penelitian'],
                'hasil_pembimbingan' => $hasilPembimbingan,
                'is_training_data' => true
            ];

            NaiveBayesTrainingData::saveTrainingData($trainingData);

            Log::info('Training data saved for pengajuan: ' . $pengajuanId);
            return true;
        } catch (\Exception $e) {
            Log::error('Error saving training data: ' . $e->getMessage());
            throw $e;
        }
    }
}
