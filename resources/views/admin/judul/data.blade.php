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
                {{ $v->nama_keahlian }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->nama_prodi }}
            </span>
        </td>
        <td>
            <div class="fw-semibold">{{ $v->nim1 }}</div>
            <div class="fw-semibold">{{ $v->nim2 }}</div>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->nidn1 }} - {{ $v->nama_dosen1 }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->nidn2 }} - {{ $v->nama_dosen2 }}
            </span>
        </td>
        <td>
            <span class="fw-semibold badge badge-{{ $v->status == 'diterima' ? 'success' : 'warning' }}">
                {{ $v->status }}
            </span>
        </td>
        <td class="text-end text-nowrap">
            @if ($v->status == 'diterima')
                <a href="{{ route('sk-pembimbing.pdf', $v->id) }}" class="btn btn-sm btn-danger" target="_blank">
                    <i class="fa fa-file-pdf"></i>
                </a>
            @endif
            {!! Helper::btnAction($v->id, $title) !!}
        </td>
    </tr>
@endforeach
