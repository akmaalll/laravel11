<?php

namespace App\Services;

use App\Models\DosenPenelitian;
use App\Models\Pembimbing;
use App\Models\TrainingData;

class NaiveBayesService
{
    public function trainAndPredict($judul, $dosenKandidat)
    {
        // Hitung probabilitas prior
        $totalPositive = TrainingData::where('cocok', 1)->count();
        $totalNegative = TrainingData::where('cocok', 0)->count();
        $totalData = $totalPositive + $totalNegative;

        $P_positive = $totalPositive / $totalData;
        $P_negative = $totalNegative / $totalData;

        $results = [];

        foreach ($dosenKandidat as $dosen) {
            // Hitung likelihood untuk setiap fitur
            $keahlianMatch = $this->calculateLikelihood(
                'keahlian_id',
                $judul->keahlian_id,
                $dosen->keahlian_id,
                $dosen->tingkat_keahlian
            );
            dd($keahlianMatch);

            $penelitianMatch = $this->calculatePenelitianLikelihood(
                $judul->keahlian_id,
                $dosen->dosen_nidn
            );

            $bimbinganMatch = $this->calculateBimbinganLikelihood(
                $dosen->dosen_nidn
            );

            // Hitung posterior probability
            $P_X_positive = $keahlianMatch['positive'] *
                $penelitianMatch['positive'] *
                $bimbinganMatch['positive'];

            $P_X_negative = $keahlianMatch['negative'] *
                $penelitianMatch['negative'] *
                $bimbinganMatch['negative'];

            $P_positive_X = $P_X_positive * $P_positive;
            $P_negative_X = $P_X_negative * $P_negative;

            // Normalisasi
            $sum = $P_positive_X + $P_negative_X;
            $probability = $sum > 0 ? $P_positive_X / $sum : 0;

            $results[] = [
                'dosen' => $dosen->dosen,
                'probability' => $probability,
                'details' => [
                    'keahlian' => $keahlianMatch,
                    'penelitian' => $penelitianMatch,
                    'bimbingan' => $bimbinganMatch
                ]
            ];
        }

        // Urutkan berdasarkan probability tertinggi
        usort($results, function ($a, $b) {
            return $b['probability'] <=> $a['probability'];
        });

        return $results;
    }

    private function calculateLikelihood($attribute, $judulValue, $dosenValue, $tingkatKeahlian)
    {
        // Hitung kemunculan di data training
        $positive = TrainingData::where($attribute, $dosenValue)
            ->where('cocok', 1)
            ->count();

        $negative = TrainingData::where($attribute, $dosenValue)
            ->where('cocok', 0)
            ->count();

        $totalPositive = TrainingData::where('cocok', 1)->count();
        $totalNegative = TrainingData::where('cocok', 0)->count();

        // Laplace smoothing untuk menghindari probabilitas 0
        $alpha = 1;
        $P_positive = ($positive + $alpha) / ($totalPositive + $alpha * 2);
        $P_negative = ($negative + $alpha) / ($totalNegative + $alpha * 2);

        // Gabungkan dengan tingkat keahlian
        return [
            'positive' => $P_positive * $tingkatKeahlian,
            'negative' => $P_negative * (1 - $tingkatKeahlian)
        ];
    }

    private function calculatePenelitianLikelihood($keahlianId, $dosenNidn)
    {
        // Hitung relevansi penelitian dosen di keahlian ini
        $relevansi = DosenPenelitian::where('dosen_nidn', $dosenNidn)
            ->where('keahlian_id', $keahlianId)
            ->avg('relevansi') ?? 0.5; // Default 0.5 jika tidak ada data

        return [
            'positive' => $relevansi,
            'negative' => 1 - $relevansi
        ];
    }

    private function calculateBimbinganLikelihood($dosenNidn)
    {
        $totalBimbingan = Pembimbing::where('dosen_nidn', $dosenNidn)->count();
        $maxBimbingan = Pembimbing::maxBimbingan(); // Misal 10

        // Semakin sedikit bimbingan, semakin tinggi probabilitas positif
        $positiveProb = 1 - ($totalBimbingan / $maxBimbingan);

        return [
            'positive' => max(0.1, $positiveProb), // Minimal 0.1
            'negative' => 1 - $positiveProb
        ];
    }
}
