<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\JudulContract;
use App\Models\Judul;
use Illuminate\Support\Facades\Session;

class JudulRepository extends BaseRepository implements JudulContract
{
	/**
	 * @var
	 */
	protected $model;

	public function __construct(Judul $model)
	{
		$this->model = $model;
	}

	public function paginatedMhs(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		$search = $criteria['search'] ?? '';

		return $this->model
			->select(
				'mst_judul.*',
				'mst_keahlian.id as id_keahlian',
				'mst_keahlian.nama as nama_keahlian',
				'mst_dosen.nama as nama_dosen1',
				'd2.nama as nama_dosen2',
				'users.name as nama_mhs1',
				'u2.name as nama_mhs2'
			)
			->join('mst_keahlian', 'mst_judul.id_keahlian', '=', 'mst_keahlian.id')
			->join('mst_dosen', 'mst_dosen.nidn', '=', 'mst_judul.nidn1')
			->join('mst_dosen as d2', 'd2.nidn', '=', 'mst_judul.nidn2')
			->join('users', 'users.username', '=', 'mst_judul.nim1')
			->join('users as u2', 'u2.username', '=', 'mst_judul.nim2')
			->when($search, function ($query) use ($search) {
				$query->where('judul', 'like', "%{$search}%");
			})
			->where('nim1', Session::get('stb'))
			->orWhere('nim2', Session::get('stb'))
			->orderBy($field, $sortOrder)
			->paginate($perPage);
	}

	public function paginated(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'created_at';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		$search = $criteria['search'] ?? '';

		return $this->model
			->select(
				'mst_judul.*',
				'mst_keahlian.id as id_keahlian',
				'mst_keahlian.nama as nama_keahlian',
				'mst_prodi.id as id_prodi',
				'mst_prodi.nama as nama_prodi',
				'd1.nama as nama_dosen1',
				'd2.nama as nama_dosen2'
			)
			->leftJoin('mst_keahlian', 'mst_judul.id_keahlian', '=', 'mst_keahlian.id')
			->leftJoin('mst_prodi', 'mst_judul.id_prodi', '=', 'mst_prodi.id')
			->leftJoin('mst_dosen as d1', 'mst_judul.nidn1', '=', 'd1.nidn')
			->leftJoin('mst_dosen as d2', 'mst_judul.nidn2', '=', 'd2.nidn')
			->when($search, function ($query) use ($search) {
				$query->where('judul', 'like', "%{$search}%");
			})
			->orderByRaw("CASE WHEN mst_judul.status = 'Diajukan' THEN 1 ELSE 2 END")
			->orderBy($field, $sortOrder)
			->paginate($perPage);
	}
}
