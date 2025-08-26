<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\MatkulDosenContract;
use App\Models\DosenMataKuliah;
use Illuminate\Support\Facades\DB;

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

		return DB::table('mst_matkul_dosen')
			->select('mst_matkul_dosen.*', 'mst_dosen.nidn as dosen_nidn', 'mst_dosen.nama as nama_dosen')
			->join('mst_dosen', 'mst_dosen.nidn', '=', 'mst_matkul_dosen.nidn')
			->when($search, function ($query) use ($search) {
				$query->where(function ($q) use ($search) {
					$q->where('dosen_nidn', 'like', "%{$search}%")
						->orWhere('dosens.nama', 'like', "%{$search}%");
				});
			})
			->orderBy($field, $sortOrder)
			->paginate($perPage);
	}
}
