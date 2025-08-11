<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\MatkulDosenContract;
use App\Models\DosenMataKuliah;

class MatkulDosenRepository extends BaseRepository implements MatkulDosenContract
{
	/**
	 * @var
	 */
	protected $model;

	public function __construct(DosenMataKuliah $model)
	{
		$this->model = $model;
	}

	public function paginated(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		$search = $criteria['search'] ?? '';

		return $this->model->when($search, function ($query) use ($search) {
			$query->where('dosen_nidn', 'like', "%{$search}%");
		})
			->orderBy($field, $sortOrder)
			->paginate($perPage);
	}
}
