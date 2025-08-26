<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\DosenPenelitianContract;
use App\Models\DosenPenelitian;
use Illuminate\Support\Facades\DB;

class DosenPenelitianRepository extends BaseRepository implements DosenPenelitianContract
{
	/**
	 * @var
	 */
	protected $model;

	public function __construct(DosenPenelitian $model)
	{
		$this->model = $model;
	}

	public function paginated(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		$search = $criteria['search'] ?? '';

		return DB::table('mst_dosen_penelitian')
			->select('mst_dosen_penelitian.*', 'mst_dosen.nama as nama_dosen')
			->join('mst_dosen', 'mst_dosen.nidn', '=', 'mst_dosen_penelitian.nidn')
			->when($search, function ($query) use ($search) {
			$query->where(function ($q) use ($search) {
					$q->where('mst_dosen_penelitian.nidn', 'like', "%{$search}%")
						->orWhere('mst_dosen.nama', 'like', "%{$search}%");
				});
			})
			->orderBy($field, $sortOrder)
			->paginate($perPage);
	}
}
