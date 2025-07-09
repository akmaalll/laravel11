<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\PengajuanJudulContract;
use App\Models\JudulSkripsi;
use App\Models\Pengajuan_judul;
use App\Models\PengajuanJudul;
use App\Models\PengusulJudul;
use Illuminate\Support\Facades\Session;

class PengajuanJudulRepository extends BaseRepository implements PengajuanJudulContract
{
	/**
	 * @var
	 */
	protected $model, $pengusul;

	public function __construct(PengajuanJudul $model, PengusulJudul $pengusul)
	{
		$this->model = $model;
		$this->pengusul = $pengusul;
	}

	public function paginated(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		return $this->model->orderBy($field, $sortOrder)->paginate($perPage);
	}

	public function paginatedByUser(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'id';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		$stb = Session::get('stb'); 

		return PengajuanJudul::with(['pengusuls'])
			->whereHas('pengusuls', function ($query) use ($stb) {
				$query->where('nim', $stb);
			})
			->orderBy($field, $sortOrder)
			->paginate($perPage);
	}
}
