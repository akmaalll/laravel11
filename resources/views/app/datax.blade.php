@foreach ($data as $key => $v)
    <tr class="text-start text-gray-600 fs-7">
        <td>
            <span class="fw-semibold">
                {{ ++$i }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->rencanaKerja->rencana ?? '' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->indikatorKinerja->indikator ?? '' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->target ?? '' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->pic ?? '' }}
            </span>
        </td>

        @php
            $summary = collect($summaryData)->firstWhere('id', $v->id)['summary'];
        @endphp

        <td>
            @if (isset($v->januari))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->januari_realisasi) || isset($v->link_data_januari) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                <div style="max-height: 100px; overflow-y: auto;">
                    <p>{{ $v->januari_realisasi }}</p>
                    @if (isset($v->link_data_januari))
<a href="#"  class="show-image" data-image="{{ asset("uploads/triwulan/{$v->link_data_januari}") }}">
                        LIHAT DATA DUKUNG
                    </a>
@endif
                </div>
                '>

                    {{ $v->januari ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($v->februari))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->februari_realisasi) || isset($v->link_data_februari) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
            <p>{{ $v->februari_realisasi }}</p>
            @if (isset($v->link_data_februari))
<a href="#" class="show-image" data-image="{{ asset("uploads/triwulan/{$v->link_data_februari}") }}">
                        LIHAT DATA DUKUNG   
                    </a>
@endif
</div>
            '>
                    {{ $v->februari ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($v->maret))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->maret_realisasi) || isset($v->link_data_maret) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
        <p>{{ $v->maret_realisasi }}</p>
        @if (isset($v->link_data_maret))
<a href="#" class="show-image" data-image="{{ asset("uploads/triwulan/{$v->link_data_maret}") }}">
                        LIHAT DATA DUKUNG 
                    </a>
@endif
</div>
        '>
                    {{ $v->maret ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($summary[0]))
                <button type="button"
                    class="btn btn-{{ $summary[0] != null ? 'success' : 'secondary' }} btn-rounded btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="tooltip" data-bs-title='{{ $v->ket_tw1 }}'>
                    {{ $summary[0] ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->kendala_tw1 ?? '-' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->tindak_lanjut_tw1 ?? '-' }}
            </span>
        </td>
        <td>
            @if (isset($v->april))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->april_realisasi) || isset($v->link_data_april) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
    <p>{{ $v->april_realisasi }}</p>
    @if (isset($v->link_data_april))
<a href="#" class="show-image" data-image="{{ asset("uploads/triwulan/{$v->link_data_april}") }}">
                        LIHAT DATA DUKUNG   
                    </a>
@endif
</div>
    '>
                    {{ $v->april ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($v->mei))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->mei_realisasi) || isset($v->link_data_mei) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
    <p>{{ $v->mei_realisasi }}</p>
    @if (isset($v->link_data_mei))
<a href="#"  class="show-image"   data-image="{{ asset("uploads/triwulan/{$v->link_data_mei}") }}">
                        LIHAT DATA DUKUNG
                    </a>
@endif
</div>
    '>
                    {{ $v->mei ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($v->juni))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->juni_realisasi) || isset($v->link_data_juni) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
        <p>{{ $v->juni_realisasi }}</p>
        @if (isset($v->link_data_juni))
<a href="#" class="show-image" data-image="{{ asset("uploads/triwulan/{$v->link_data_juni}") }}">
                        LIHAT DATA DUKUNG
                    </a>
@endif
</div>
        '>
                    {{ $v->juni ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($summary[1]))
                <button type="button"
                    class="btn btn-{{ $summary[1] != null ? 'success' : 'secondary' }} btn-rounded btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="tooltip" data-bs-title='{{ $v->ket_tw2 }}'>
                    {{ $summary[1] ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->kendala_tw2 ?? '-' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->tindak_lanjut_tw2 ?? '-' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->semester1 ?? '-' }}
            </span>
        </td>
        <td>
            @if (isset($v->juli))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->juli_realisasi) || isset($v->link_data_juli) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
    <p>{{ $v->juli_realisasi }}</p>
    @if (isset($v->link_data_juli))
<a href="#" class="show-image" data-image="{{ asset("uploads/triwulan/{$v->link_data_juli}") }}">
                        LIHAT DATA DUKUNG 
                    </a>
@endif
</div>
    '>
                    {{ $v->juli ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($v->agustus))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->link_data_agustus) || isset($v->link_data_agustus) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
        <p>{{ $v->agustus_realisasi }}</p>
        @if (isset($v->link_data_agustus))
<a href="#"  class="show-image"  data-image="{{ asset("uploads/triwulan/{$v->link_data_agustus}") }}"> LIHAT DATA DUKUNG  </a>
@endif
</div>
        '>
                    {{ $v->agustus ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($v->september))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->september_realisasi) || isset($v->link_data_september) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
        <p>{{ $v->september_realisasi }}</p>
        @if (isset($v->link_data_september))
<a href="#" class="show-image" data-image="{{ asset("uploads/triwulan/{$v->link_data_september}") }}"> LIHAT DATA DUKUNG </a>
@endif
</div>
        '>
                    {{ $v->september ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($summary[2]))
                <button type="button"
                    class="btn btn-{{ $summary[2] != null ? 'success' : 'secondary' }} btn-rounded btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="tooltip" data-bs-title='{{ $v->ket_tw3 }}'>
                    {{ $summary[2] ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->kendala_tw3 ?? '-' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->tindak_lanjut_tw3 ?? '-' }}
            </span>
        </td>
        <td>
            @if (isset($v->oktober))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->oktober_realisasi) || isset($v->link_data_oktober) ? 'tooltip' : '' }}"
                    data-bs-html="true" data-bs-custom-class="tooltip-scroll"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
    <p>{{ $v->oktober_realisasi }}</p>
    @if (isset($v->link_data_oktober))
<a href="#" class="show-image" data-image="{{ asset("uploads/triwulan/{$v->link_data_oktober}") }}"> LIHAT DATA DUKUNG  </a>
@endif
</div>
    '>
                    {{ $v->oktober ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($v->november))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->november_realisasi) || isset($v->link_data_november) ? 'tooltip' : '' }}"
                    data-bs-html="true"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
        <p>{{ $v->november_realisasi }}</p>
        @if (isset($v->link_data_november))
<a href="#"  class="show-image"  data-image="{{ asset("uploads/triwulan/{$v->link_data_november}") }}">
                        LIHAT DATA DUKUNG
                    </a>
@endif
</div>
        '>
                    {{ $v->november ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($v->desember))
                <button type="button" class="btn btn-secondary btn-rounded btn-sm btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="{{ isset($v->desember_realisasi) || isset($v->link_data_desember) ? 'tooltip' : '' }}"
                    data-bs-html="true"
                    data-bs-title='
                    <div style="max-height: 100px; overflow-y: auto;">
                        <p>{{ $v->desember_realisasi }}</p>
                        @if (isset($v->link_data_desember))
<a href="#" class="show-image" data-image="{{ asset("uploads/triwulan/{$v->link_data_desember}") }}"> LIHAT DATA DUKUNG </a>
@endif 
</div>'>
                    {{ $v->desember ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            @if (isset($summary[3]))
                <button type="button"
                    class="btn btn-{{ $summary[3] != null ? 'success' : 'secondary' }} btn-rounded btn-sm"
                    style="font-size: 0.97rem; float:{{ $v->indikatorKinerja->tipe < 4 ? 'right' : 'center' }};"
                    data-bs-toggle="tooltip" data-bs-title='{{ $v->ket_tw4 }}'>
                    {{ $summary[3] ?? '-' }}
                </button>
            @else
                -
            @endif
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->kendala_tw4 ?? '-' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->tindak_lanjut_tw4 ?? '-' }}
            </span>
        </td>
        <td>
            <span class="fw-semibold">
                {{ $v->semester2 ?? '-' }}
            </span>
        </td>
    </tr>
@endforeach
