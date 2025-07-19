<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\DosenRecommenderContract;
use App\Models\Dosen;
use App\Models\KeahlianDosen;
use Phpml\Classification\NaiveBayes;
use Phpml\FeatureExtraction\TfidfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;

class DosenRecommenderRepository extends BaseRepository implements DosenRecommenderContract
{
	protected $model, $keahlianDosen;

	public function __construct(Dosen $model, KeahlianDosen $keahlianDosen)
	{
		$this->model = $model;
		$this->keahlianDosen = $keahlianDosen;
	}

	public function paginated(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		return $this->model->orderBy($field, $sortOrder)->paginate($perPage);
	}

	public function recommend($topik, $limit = 3)
	{
		try {
			// Ambil semua dosen dengan keahliannya
			$dosenKeahlians = $this->keahlianDosen->with(['dosen', 'keahlian'])->get();

			if ($dosenKeahlians->isEmpty()) {
				throw new \Exception('Tidak ada data dosen dan keahlian yang tersedia');
			}

			// Persiapan data training
			$samples = [];
			$labels = [];
			$dosenMap = [];

			foreach ($dosenKeahlians as $dk) {
				if ($dk->dosen && $dk->keahlian) {
					$keahlianText = $this->preprocessText($dk->keahlian->nama);
					$samples[] = $keahlianText;
					$labels[] = $dk->dosen->nidn;

					// Simpan mapping untuk kemudahan akses
					if (!isset($dosenMap[$dk->dosen->nidn])) {
						$dosenMap[$dk->dosen->nidn] = [
							'dosen' => $dk->dosen,
							'keahlians' => []
						];
					}
					$dosenMap[$dk->dosen->nidn]['keahlians'][] = $dk->keahlian->nama;
				}
			}

			if (empty($samples)) {
				throw new \Exception('Tidak ada data training yang valid');
			}

			// Vectorisasi dan TF-IDF
			$tokenizer = new WordTokenizer();
			$vectorizer = new TokenCountVectorizer($tokenizer);
			$vectorizer->fit($samples);
			$vectorizer->transform($samples);

			$tfidf = new TfidfTransformer();
			$tfidf->fit($samples);
			$tfidf->transform($samples);

			// Train model Naive Bayes
			$classifier = new NaiveBayes();
			$classifier->train($samples, $labels);

			// Prediksi untuk topik
			$testSample = [$this->preprocessText($topik)];
			$vectorizer->transform($testSample);
			$tfidf->transform($testSample);

			// Dapatkan prediksi
			$predictedNidn = $classifier->predict($testSample)[0];

			// Cari dosen berdasarkan NIDN
			$recommendedDosen = $this->keahlianDosen->where('dosen_id', $predictedNidn)->first();
			// dd($predictedNidn);

			if (!$recommendedDosen) {
				throw new \Exception('Dosen dengan NIDN ' . $predictedNidn . ' tidak ditemukan');
			}

			return $recommendedDosen;
		} catch (\Exception $e) {
			\Log::error('Error in dosen recommendation: ' . $e->getMessage());

			// Fallback: return dosen dengan keahlian yang mirip secara manual
			return $this->fallbackRecommendation($topik);
		}
	}

	/**
	 * Alternatif rekomendasi yang lebih robust menggunakan similarity scoring
	 */
	public function recommendWithSimilarity($topik, $limit = 3)
	{
		try {
			$dosenKeahlians = $this->keahlianDosen->with(['dosen', 'keahlian'])->get();

			if ($dosenKeahlians->isEmpty()) {
				throw new \Exception('Tidak ada data dosen dan keahlian yang tersedia');
			}

			$topikProcessed = $this->preprocessText($topik);
			$topikWords = explode(' ', $topikProcessed);

			$dosenScores = [];

			foreach ($dosenKeahlians as $dk) {
				if ($dk->dosen && $dk->keahlian) {
					$keahlianProcessed = $this->preprocessText($dk->keahlian->nama);
					$keahlianWords = explode(' ', $keahlianProcessed);

					// Hitung similarity score
					$score = $this->calculateSimilarity($topikWords, $keahlianWords);

					$nidn = $dk->dosen->nidn;
					if (!isset($dosenScores[$nidn])) {
						$dosenScores[$nidn] = [
							'dosen' => $dk->dosen,
							'score' => 0,
							'keahlians' => []
						];
					}

					// Akumulasi score dan keahlian
					$dosenScores[$nidn]['score'] += $score;
					$dosenScores[$nidn]['keahlians'][] = $dk->keahlian->nama;
				}
			}

			// Sort berdasarkan score tertinggi
			uasort($dosenScores, function ($a, $b) {
				return $b['score'] <=> $a['score'];
			});

			// Ambil dosen dengan score tertinggi
			$topDosen = array_slice($dosenScores, 0, $limit, true);

			if (empty($topDosen)) {
				throw new \Exception('Tidak ada dosen yang sesuai dengan topik');
			}

			// Return dosen pertama (score tertinggi)
			return array_values($topDosen)[0]['dosen'];
		} catch (\Exception $e) {
			\Log::error('Error in similarity recommendation: ' . $e->getMessage());
			return $this->fallbackRecommendation($topik);
		}
	}

	/**
	 * Fallback recommendation jika machine learning gagal
	 */
	private function fallbackRecommendation($topik)
	{
		try {
			// Cari dosen yang keahliannya mengandung kata kunci dari topik
			$topikWords = explode(' ', $this->preprocessText($topik));

			$dosenKeahlians = $this->keahlianDosen->with(['dosen', 'keahlian'])
				->whereHas('keahlian', function ($query) use ($topikWords) {
					foreach ($topikWords as $word) {
						$query->orWhere('nama', 'LIKE', '%' . $word . '%');
					}
				})
				->first();

			if ($dosenKeahlians && $dosenKeahlians->dosen) {
				return $dosenKeahlians->dosen;
			}

			// Jika masih tidak ada, return dosen random
			return $this->model->inRandomOrder()->first();
		} catch (\Exception $e) {
			\Log::error('Error in fallback recommendation: ' . $e->getMessage());
			return $this->model->inRandomOrder()->first();
		}
	}

	/**
	 * Hitung similarity antara dua array kata
	 */
	private function calculateSimilarity($words1, $words2)
	{
		$intersection = array_intersect($words1, $words2);
		$union = array_unique(array_merge($words1, $words2));

		if (empty($union)) {
			return 0;
		}

		// Jaccard similarity
		return count($intersection) / count($union);
	}

	/**
	 * Preprocessing text yang lebih comprehensive
	 */
	private function preprocessText($text)
	{
		// Convert to lowercase
		$text = strtolower($text);

		// Remove special characters, keep only alphanumeric and spaces
		$text = preg_replace('/[^a-z0-9\s]/', '', $text);

		// Indonesian stopwords
		$stopwords = [
			'dan',
			'atau',
			'dengan',
			'pada',
			'di',
			'ke',
			'dari',
			'untuk',
			'dalam',
			'yang',
			'ini',
			'itu',
			'adalah',
			'akan',
			'telah',
			'sudah',
			'bisa',
			'dapat',
			'harus',
			'tidak',
			'ada',
			'juga',
			'serta',
			'oleh',
			'karena',
			'hingga',
			'sampai',
			'namun',
			'tetapi',
			'namun',
			'bahwa',
			'sebagai',
			'tentang',
			'antara'
		];

		// Split into words
		$words = array_filter(explode(' ', $text));

		// Remove stopwords
		$words = array_diff($words, $stopwords);

		// Remove empty strings and single characters
		$words = array_filter($words, function ($word) {
			return strlen($word) > 1;
		});

		return implode(' ', $words);
	}

	/**
	 * Get multiple recommendations
	 */
	public function getMultipleRecommendations($topik, $count = 2)
	{
		try {
			$recommendations = [];

			// Primary recommendation using Naive Bayes
			$primary = $this->recommend($topik);
			if ($primary) {
				$recommendations[] = $primary;
			}

			// Secondary recommendations using similarity
			$dosenKeahlians = $this->keahlianDosen->with(['dosen', 'keahlian'])
				->whereHas('dosen', function ($query) use ($primary) {
					if ($primary) {
						$query->where('nidn', '!=', $primary->nidn);
					}
				})
				->get();
			// dd($dosenKeahlians);


			$topikProcessed = $this->preprocessText($topik);
			$topikWords = explode(' ', $topikProcessed);

			$dosenScores = [];

			foreach ($dosenKeahlians as $dk) {
				if ($dk->dosen && $dk->keahlian) {
					$keahlianProcessed = $this->preprocessText($dk->keahlian->nama);
					$keahlianWords = explode(' ', $keahlianProcessed);
					// dd($keahlianProcessed);

					$score = $this->calculateSimilarity($topikWords, $keahlianWords);

					$nidn = $dk->dosen->nidn;
					if (!isset($dosenScores[$nidn])) {
						$dosenScores[$nidn] = [
							'dosen' => $dk->dosen,
							'score' => 0
						];
					}

					$dosenScores[$nidn]['score'] += $score;
				}
			}

			// Sort by score
			uasort($dosenScores, function ($a, $b) {
				return $b['score'] <=> $a['score'];
			});

			// Add secondary recommendations
			$needed = $count - count($recommendations);
			$secondaryDosens = array_slice($dosenScores, 0, $needed, true);

			foreach ($secondaryDosens as $dosenScore) {
				$recommendations[] = $dosenScore['dosen'];
			}

			// If still need more, add random dosens
			if (count($recommendations) < $count) {
				$excludeIds = array_map(function ($dosen) {
					return $dosen->nidn;
				}, $recommendations);

				$randomDosens = $this->model->whereNotIn('nidn', $excludeIds)
					->inRandomOrder()
					->limit($count - count($recommendations))
					->get();

				foreach ($randomDosens as $dosen) {
					$recommendations[] = $dosen;
				}
			}

			return array_slice($recommendations, 0, $count);
		} catch (\Exception $e) {
			\Log::error('Error in multiple recommendations: ' . $e->getMessage());
			return $this->model->inRandomOrder()->limit($count)->get()->toArray();
		}
	}
}
