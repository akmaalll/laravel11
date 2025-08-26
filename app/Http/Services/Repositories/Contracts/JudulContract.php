<?php

namespace App\Http\Services\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface JudulContract
{
	/**
	 * params string $search
	 * @return Collection
	*/

	public function paginated(array $request);
	public function paginatedMhs(array $request);
}