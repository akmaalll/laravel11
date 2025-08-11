@foreach ($data as $dosenId => $keahlians)
    <tr>
        <td>{{ ++$i }}</td>
        <td>
            <div class="d-flex flex-column">
                <span class="fw-semibold text-gray-800 fs-6">
                    {{ $keahlians->first()->dosen->nama ?? '-' }}
                </span>
                @if ($keahlians->first()->dosen->nidn)
                    <small class="text-muted">NIDN: {{ $keahlians->first()->dosen->nidn }}</small>
                @endif
            </div>
        </td>
        <td>
            @foreach ($keahlians as $keahlian)
                {{ $keahlian->keahlian->nama ?? '-' }}@if (!$loop->last)
                    ,
                @endif
            @endforeach
        </td>
    </tr>
@endforeach
