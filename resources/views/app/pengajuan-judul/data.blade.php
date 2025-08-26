@foreach ($data as $key => $v)
    <tr class="text-start text-gray-600 fs-7">
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->nim1 . '-' . $v->nama_mhs1 . ' | ' . $v->nim2 . '-' . $v->nama_mhs2 }}
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
                {{ $v->nama_dosen1 ?? '' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->nama_dosen2 ?? '' }}
            </span>
        </td>
        <td align="center">
            <span
                class="fw-semibold badge 
                    @if ($v->status == 'diterima') badge-success 
                    @elseif($v->status == 'diajukan') badge-warning 
                    @elseif($v->status == 'ditolak') badge-danger 
                    @else badge-secondary @endif">
                {{ $v->status ?? '' }}
            </span>
        </td>
        <td align="center">
            <div class="d-flex justify-content-center gap-2">

                <button class="btn btn-sm btn-icon btn-info detail-judul" data-id="{{ $v->id }}">
                    <i class="fa fa-eye"></i>
                </button>

                @if ($v->status == 'draft' && $v->nim2 == Session::get('stb'))
                    {{-- Approve / Reject hanya untuk nim2 --}}
                    <button type="submit" data-id="{{ $v->id }}"
                        class="btn btn-approve btn-icon btn-success btn-sm">
                        <i class="ki-duotone ki-check-circle">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                    <button type="submit" data-id="{{ $v->id }}"
                        class="btn btn-reject btn-icon btn-danger btn-sm">
                        <i class="ki-duotone ki-cross-circle">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                @elseif (($v->status == 'draft' || $v->status == 'diajukan') && $v->nim1 == Session::get('stb'))
                    {{-- Edit --}}
                    <a href="{{ route('judul.edit.step2', $v->id) }}">
                        <button type="button" class="btn btn-icon btn-bg-secondary btn-active-color-primary btn-sm">
                            <i class="ki-duotone ki-pencil fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                    </a>

                    {{-- Delete --}}
                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $v->id }}" title="Delete"
                        class="deleteData">
                        <button type="button" class="btn btn-icon btn-bg-secondary btn-active-color-primary btn-sm">
                            <i class="ki-duotone ki-trash fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </button>
                    </a>
                @endif
            </div>
        </td>

    </tr>
@endforeach
