<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\PembimbingContract;
use App\Models\Pembimbing;

class PembimbingRepository extends BaseRepository implements PembimbingContract
{
	/**
	 * @var
	 */
	protected $model;

	public function __construct(Pembimbing $model)
	{
		$this->model = $model;
	}

	public function paginated(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		return $this->model->orderBy($field, $sortOrder)->paginate($perPage);
	}

	/**
	 * Rekomendasi pembimbing menggunakan Naive Bayes
	 * @param string $judul
	 * @param string $topik
	 * @return array
	 */
	// public function getNaiveBayesRecommendations($judul, $topik)
	// {
	// 	// Ambil data training
	// 	$training = \App\Models\NaiveBayesTrainingData::all();
	// 	$dosens = \App\Models\Dosen::all();
	// 	$scores = [];

	// 	// Hitung prior untuk setiap dosen
	// 	$total = $training->count();
	// 	$dosenCounts = $training->groupBy('dosen_nidn')->map->count();

	// 	foreach ($dosens as $dosen) {
	// 		$prior = ($dosenCounts[$dosen->nidn] ?? 1) / max($total, 1); // Laplace smoothing
	// 		$likelihood = 1;

	// 		// Likelihood: topik skripsi
	// 		$topikCount = $training->where('dosen_nidn', $dosen->nidn)->where('topik_skripsi', $topik)->count();
	// 		$likelihood *= ($topikCount + 1) / (($dosenCounts[$dosen->nidn] ?? 1) + 1); // Laplace

	// 		// Likelihood: keahlian dosen (cocokkan topik dengan keahlian)
	// 		$keahlianMatch = 0;
	// 		$keahlianTotal = 0;
	// 		foreach ($training->where('dosen_nidn', $dosen->nidn) as $row) {
	// 			$keahlian = json_decode($row->keahlian_dosen, true);
	// 			if (is_array($keahlian)) {
	// 				$keahlianTotal += count($keahlian);
	// 				foreach ($keahlian as $k) {
	// 					if (stripos($topik, $k) !== false || stripos($k, $topik) !== false) {
	// 						$keahlianMatch++;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$likelihood *= ($keahlianMatch + 1) / max($keahlianTotal, 1);

	// 		// Likelihood: history bimbingan (cocokkan topik dengan history)
	// 		$bimbinganMatch = 0;
	// 		$bimbinganTotal = 0;
	// 		foreach ($training->where('dosen_nidn', $dosen->nidn) as $row) {
	// 			$bimbingan = json_decode($row->history_bimbingan, true);
	// 			if (is_array($bimbingan)) {
	// 				$bimbinganTotal += count($bimbingan);
	// 				foreach ($bimbingan as $b) {
	// 					if (stripos($topik, $b) !== false || stripos($b, $topik) !== false) {
	// 						$bimbinganMatch++;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$likelihood *= ($bimbinganMatch + 1) / max($bimbinganTotal, 1);

	// 		// Likelihood: history penelitian (cocokkan topik dengan penelitian)
	// 		$penelitianMatch = 0;
	// 		$penelitianTotal = 0;
	// 		foreach ($training->where('dosen_nidn', $dosen->nidn) as $row) {
	// 			$penelitian = json_decode($row->history_penelitian, true);
	// 			// dd($row);
	// 			if (is_array($penelitian)) {
	// 				$penelitianTotal += count($penelitian);
	// 				foreach ($penelitian as $p) {
	// 					if (stripos($topik, $p) !== false || stripos($p, $topik) !== false) {
	// 						$penelitianMatch++;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$likelihood *= ($penelitianMatch + 1) / max($penelitianTotal, 1);

	// 		// Skor akhir
	// 		$scores[$dosen->nidn] = [
	// 			'nama' => $dosen->nama,
	// 			'skor' => $prior * $likelihood,
	// 			'nidn' => $dosen->nidn,
	// 			'keahlian' => $dosen->keahlian ? json_decode($dosen->keahlian, true) : [],
	// 		];
	// 	}

	// 	// Urutkan skor tertinggi
	// 	uasort($scores, function ($a, $b) {
	// 		return $b['skor'] <=> $a['skor'];
	// 	});
	// 	return $scores;
	// }
}
