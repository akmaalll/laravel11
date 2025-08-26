<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Repositories\BaseRepository;
use App\Http\Services\Repositories\Contracts\DosenContract;
use App\Models\Dosen;

class DosenRepository extends BaseRepository implements DosenContract
{
	/**
	 * @var
	 */
	protected $model;

	public function __construct(Dosen $model)
	{
		$this->model = $model;
	}

	public function paginated(array $criteria)
	{
		$perPage = $criteria['per_page'] ?? 5;
		$field = $criteria['sort_field'] ?? 'nidn';
		$sortOrder = $criteria['sort_order'] ?? 'desc';
		$search = $criteria['search'] ?? '';

		return $this->model->when($search, function ($query) use ($search) {
			$query->where('nama', 'like', "%{$search}%");
			$query->orWhere('nidn', 'like', "%{$search}%");
		})
			->orderBy($field, $sortOrder)
			->paginate($perPage);
	}

	public function updates(array $data, $id)
	{
		$dosen = Dosen::findOrFail($id);

		if (isset($data['id_keahlian']) && is_array($data['id_keahlian'])) {
			$data['id_keahlian'] = json_encode($data['id_keahlian']);
		}

		$dosen->update($data);
		return $dosen;
	}
}
