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
                @if (auth()->user()->id_role == 4 && !$v->sk_pembimbing)
                    <a href="{{ route('sk-pembimbing', $v->id) }}" class="btn btn-sm btn-danger">
                        <i class="fa fa-file-pdf"></i> Input No SK
                    </a>
                @endif

                @if ($v->sk_pembimbing)
                    <a href="{{ route('sk-pembimbing.download', $v->id) }}" class="btn btn-sm btn-primary"
                        target="_blank">
                        <i class="fas fa-download"></i> Download
                    </a>
                @endif
            @endif
            {!! Helper::btnAction($v->id, $title) !!}
        </td>
    </tr>
@endforeach
