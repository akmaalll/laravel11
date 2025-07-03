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
    </tr>
@endforeach
