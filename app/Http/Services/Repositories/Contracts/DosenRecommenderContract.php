<?php

namespace App\Http\Services\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface DosenRecommenderContract
{
	/**
	 * params string $search
	 * @return Collection
	 */

	public function paginated(array $request);
	public function recommend($topik, $limit);
	public function recommendWithSimilarity($topik, $limit);
	public function getMultipleRecommendations($topik, $count);
}
