<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\KeahlianContract;
use App\Models\KeahlianDosen;

class KeahlianRepository extends BaseRepository implements KeahlianContract
{
	/**
	 * @var
	 */
	protected $model;

	public function __construct(KeahlianDosen $model)
	{
		$this->model = $model;
	}

	public function paginated(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'dosen_id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';

		// Ambil daftar dosen unik untuk pagination
		$dosenPaginated = $this->model
			->select('dosen_id')
			->groupBy('dosen_id')
			->orderBy($field, $sortOrder)
			->paginate($perPage);

		// Ambil semua data keahlian dari dosen yang ada di halaman ini
		$allData = $this->model
			->whereIn('dosen_id', $dosenPaginated->pluck('dosen_id'))
			->with(['dosen', 'keahlian'])
			->get()
			->groupBy('dosen_id');

		return [
			'pagination' => $dosenPaginated,
			'grouped'    => $allData
		];
	}
}
