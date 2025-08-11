<?php

namespace App\Services;

use App\Models\Dosen;
use App\Models\MstKeahlian;

class NaiveBayesKeahlianDosenService
{
    private $trainingData = [];
    private $topN = 3; // Number of top predictions to return

    public function __construct()
    {
        $this->loadTrainingData();
    }

    private function loadTrainingData()
    {
        // Get dosens with keahlians as training data
        $dosens = Dosen::has('keahlians')->with(['mataKuliah', 'keahlians'])->get();

        foreach ($dosens as $dosen) {
            $mataKuliah = $dosen->mataKuliah->pluck('mata_kuliah')->toArray();
            $keahlian = $dosen->keahlians->first()->nama;

            $this->trainingData[] = [
                'features' => $mataKuliah,
                'label' => $keahlian
            ];
        }
    }

    public function predict($mataKuliah)
    {
        $labels = array_column($this->trainingData, 'label');
        $uniqueLabels = array_unique($labels);
        $probabilities = [];

        foreach ($uniqueLabels as $label) {
            // Calculate prior probability P(Keahlian)
            $prior = count(array_keys($labels, $label)) / count($this->trainingData);

            // Calculate likelihood P(MataKuliah|Keahlian)
            $likelihood = 1.0;
            foreach ($mataKuliah as $mk) {
                $count = 0;
                foreach ($this->trainingData as $data) {
                    if ($data['label'] === $label && in_array($mk, $data['features'])) {
                        $count++;
                    }
                }
                // Laplace smoothing to avoid zero probability
                $likelihood *= ($count + 1) / (count(array_keys($labels, $label)) + count($uniqueLabels));
            }

            $probabilities[$label] = $prior * $likelihood;
        }

        // Normalize probabilities to sum to 1
        $total = array_sum($probabilities);
        if ($total > 0) {
            $normalizedProbabilities = array_map(function ($value) use ($total) {
                return $value / $total;
            }, $probabilities);
        } else {
            $normalizedProbabilities = $probabilities;
        }

        // Sort by probability (descending)
        arsort($normalizedProbabilities);

        // Return top N predictions with their probabilities
        return array_slice($normalizedProbabilities, 0, $this->topN, true);
    }

    public function predictForDosen(Dosen $dosen)
    {
        $mataKuliah = $dosen->mataKuliah->pluck('mata_kuliah')->toArray();
        $predictions = $this->predict($mataKuliah);

        return [
            'dosen' => $dosen->nama,
            'mata_kuliah' => $mataKuliah,
            'predicted_keahlian' => $predictions  // Changed from 'predicted_keahlians'
        ];
    }
}