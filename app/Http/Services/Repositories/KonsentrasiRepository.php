<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\KonsentrasiContract;
use App\Http\Services\Repositories\Contracts\ProdiContract;
use App\Models\Konsentrasi;
use App\Models\Prodi;

class KonsentrasiRepository extends BaseRepository implements KonsentrasiContract
{
	/**
	 * @var
	 */
	protected $model;

	public function __construct(Konsentrasi $model)
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
}
