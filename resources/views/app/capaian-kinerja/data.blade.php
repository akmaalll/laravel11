@foreach ($data as $key => $v)
    <tr class="text-start text-gray-600 fs-7">
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->rencanaKerja->rencana ?? '' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->indikatorKinerja->indikator ?? '' }}
            </span>
        </td>
        <td align="center">
            <span class="fw-semibold">
                {{ $v->target ?? '' }}
            </span>
        </td>

        <td align="center">
            <a href="{{ url('capaian-kinerja/' . $v->id . '/detail') }}"
                class="btn btn-sm fw-bold btn-secondary btn-rounded" style="font-size: 0.90rem; float:center">
                <span class="btn-label">
                    <i class="fa fa-search"></i>
                </span>
            </a>
        </td>
    </tr>
@endforeach
