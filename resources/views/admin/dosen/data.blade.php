@foreach ($data as $key => $v)
    <tr class="text-start text-gray-600 fs-7">
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->nidn }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->nama }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->email }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->keahlian->nama }}
            </span>
        </td>
        <td class="text-end">
            {!! Helper::btnAction($v->nidn, $title) !!}
        </td>
    </tr>
@endforeach
