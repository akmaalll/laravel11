<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\KeahlianJudulDosenContract;
use App\Models\KeahlianJudulDosen;
use Illuminate\Support\Facades\DB;

class KeahlianJudulDosenRepository extends BaseRepository implements KeahlianJudulDosenContract
{
	/**
	 * @var
	 */
	protected $model;

	public function __construct(KeahlianJudulDosen $model)
	{
		$this->model = $model;
	}

	public function paginated(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		$search = $criteria['search'] ?? '';

		return DB::table('mst_keahlian_judul_dosen')
			->select(
				'mst_keahlian_judul_dosen.*',
				'mst_dosen_penelitian.nidn as dosen_nidn',
				'mst_dosen.nama as nama_dosen',
				'mst_dosen_penelitian.judul_penelitian as judul_penelitian',
				'mst_keahlian.nama as nama_keahlian'
			)
			->join('mst_dosen_penelitian', 'mst_dosen_penelitian.id', '=', 'mst_keahlian_judul_dosen.id_dosen_penelitian')
			->join('mst_dosen', 'mst_dosen.nidn', '=', 'mst_dosen_penelitian.nidn')
			->join('mst_keahlian', 'mst_keahlian.id', '=', 'mst_keahlian_judul_dosen.id_keahlian')
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
