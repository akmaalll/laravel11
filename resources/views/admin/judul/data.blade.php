@foreach ($data as $key => $v)
    <tr class="text-start text-gray-600 fs-7">
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->judul }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->topik }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->prodi->nama }}
            </span>
        </td>
        <td>
            @if ($v->nidn_p1 && $v->p1)
                {{ $v->p1->nama }}
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            @if ($v->nidn_p2 && $v->p2)
                {{ $v->p2->nama }}
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td class="text-end">
            {!! Helper::btnAction($v->id, $title) !!}
        </td>
    </tr>
@endforeach
