@foreach ($data as $key => $v)
    <tr class="text-start text-gray-600 fs-7">
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->dosen->nama }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->mata_kuliah }} - {{ $v->kode_mk }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->semester }}
            </span>
        </td>
        <td class="text-end">
            {{-- {!! Helper::btnAction($v->id, $title) !!} --}}
        </td>
    </tr>
@endforeach
