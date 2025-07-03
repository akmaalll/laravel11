<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\PengajuanJudulContract;
use App\Models\JudulSkripsi;
use App\Models\Pengajuan_judul;
use App\Models\PengajuanJudul;

class PengajuanJudulRepository extends BaseRepository implements PengajuanJudulContract
{
	/**
	 * @var
	 */
	protected $model;

	public function __construct(PengajuanJudul $model)
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