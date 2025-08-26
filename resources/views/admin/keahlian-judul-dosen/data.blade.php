@foreach ($data as $key => $v)
    <tr>
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->dosen_nidn }} - {{ $v->nama_dosen }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->judul_penelitian }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->nama_keahlian }}
            </span>
        </td>
        <td class="text-end">
            {!! Helper::btnAction($v->id, $title) !!}
        </td>
    </tr>
@endforeach
