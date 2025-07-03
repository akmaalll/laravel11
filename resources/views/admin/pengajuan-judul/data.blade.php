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
                {{ $v->deskripsi }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                @foreach ($v->pengusul as $pengusul)
                    <div>{{ $pengusul->nim }} </div>
                @endforeach
            </span>
        </td>
        <td>
            <span class="fw-semibold badge badge-light-warning">
                {{ $v->status }}
            </span>
        </td>
        <td class="text-end">
            {!! Helper::btnAction($v->id, $title) !!}
            {{-- <a href="{{ route('pengajuan-judul.edit', $v->id) }}" class="">
                <button type="button" class="btn btn-icon btn-bg-secondary btn-active-color-primary btn-sm me-1">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
            </a> --}}
        </td>
    </tr>
@endforeach
