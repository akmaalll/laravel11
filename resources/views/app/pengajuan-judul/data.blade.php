@foreach ($data as $key => $v)
    <tr class="text-start text-gray-600 fs-7">
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                @foreach ($v->pengusuls as $pengusul)
                    {{ $pengusul->nim }} - {{ $pengusul->nama }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
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
        <td align="center">
            <span class="fw-semibold badge badge-{{ $v->status == 'diterima' ? 'success' : 'warning' }}">
                {{ $v->status ?? '' }}
            </span>
        </td>
    </tr>
@endforeach
