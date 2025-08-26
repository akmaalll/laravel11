@foreach ($data as $key => $v)
    <tr>
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->nidn }} - {{ $v->nama }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->matkul }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->keahlian }}
            </span>
        </td>
        <td class="text-end">
            {{-- {!! Helper::btnAction($v->id, $title) !!} --}}
        </td>
    </tr>
@endforeach
