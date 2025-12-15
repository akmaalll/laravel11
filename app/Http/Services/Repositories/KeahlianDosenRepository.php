<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\KeahlianContract;
use App\Http\Services\Repositories\Contracts\KeahlianDosenContract;
use App\Models\Keahlian;
use App\Models\KeahlianDosen;
use Illuminate\Support\Facades\DB;

class KeahlianDosenRepository extends BaseRepository implements KeahlianDosenContract
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
		$field = $criteria['sort_field'] ?? 'id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		$search = $criteria['search'] ?? '';

		// dd();
		// return DB::table('KeahlianDosenView')
		// 	->select(
		// 		'KeahlianDosenView.*',
		// 	)->orderBy($field, $sortOrder)
		// 	->paginate($perPage);
		return DB::table('mst_keahlian_dosen')
			->select(
				'mst_keahlian_dosen.*',
				'mst_matkul_dosen.nidn as nidn_dosen',
				'mst_matkul_dosen.id as id_matkul_dosen',
				'mst_keahlian.id as id_keahlian',
				'mst_keahlian.nama as nama_keahlian',
				'mst_dosen.nama as nama_dosen',
				'mst_matkul_dosen.matkul as nama_matkul',
			)
			->join('mst_matkul_dosen', 'mst_matkul_dosen.id', '=', 'mst_keahlian_dosen.id_matkul_dosen')
			->join('mst_dosen', 'mst_dosen.nidn', '=', 'mst_matkul_dosen.nidn')
			->join('mst_keahlian', 'mst_keahlian.id', '=', 'mst_keahlian_dosen.id_keahlian')
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
