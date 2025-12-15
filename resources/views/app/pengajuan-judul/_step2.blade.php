<div class="flex-column">
    <!--begin::Input group-->
    <div class="row g-9 mb-8">
        <label class="fs-5 fw-bold">1.1 Identitas Usulan Penelitian</label>

        <div class="col-md-6">
            <div class="col-md-12 fv-row mb-6">
                <label class="required fs-6 fw-semibold mb-2">1. Judul</label>
                <textarea data-kt-autosize="true" id="judul" name="judul" placeholder="Judul" class="form-control" readonly>{{ isset($data->judul) ? $data->judul : null }}</textarea>
                {{-- <input type="text" class="form-control" placeholder="Judul" name="judul" id="judul"
                value="{{ isset($data['judul']) ? $data['judul'] : null }}" readonly /> --}}
            </div>
            <div class="col-md-12 fv-row mb-6">
                <label class="required fs-6 fw-semibold mb-2">2. Topik</label>
                <input type="hidden" name="id_keahlian" id="id_topik">
                <input type="hidden" name="nim1" value="{{ Session::get('stb', '') }}">
                <input type="text" class="form-control form-control-solid" placeholder="" name="topik"
                    id="topik" value="{{ $data->nama_keahlian ?? '-' }}" readonly />
            </div>
        </div>
        <div class="col-md-6">
            <div class=" col-md-12 fv-row mb-6">
                <label class="required fs-6 fw-semibold mb-2">2. Prodi</label>
                <select class="form-select" data-control="select2" data-hide-search="true"
                    data-placeholder="Select a Keahlian" name="id_prodi" id="id_prodi" readonly>
                    <option value="">Select user...</option>
                    @foreach (Helper::getData('mst_prodi') as $v)
                        <option value="{{ $v->id }}"
                            @if (isset($data->id_prodi) && $data->id_prodi == $v->id) selected
                            @elseif(!isset($data->id_prodi) && Session::get('prodi_kode') == $v->kode)
                                selected @endif>
                            {{ $v->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class=" col-md-12 fv-row mb-6">
                <label class="required fs-6 fw-semibold mb-2">2. Konsentrasi</label>
                <select class="form-select" data-control="select2" data-hide-search="true"
                    data-placeholder="Select Konsentrasi" name="konsentrasi" id="konsentrasi">
                    <option value="">Select Konsentrasi...</option>
                    @foreach (Helper::getData('mst_konsentrasi') as $v)
                        @if ($v->id_prodi == Session::get('prodi_kode'))
                            <option value="{{ $v->id }}"
                                {{ isset($data->konsentrasi) && $data->konsentrasi == $v->id ? 'selected' : '' }}>
                                {{ $v->nama }}
                            </option>
                        @endif
                    @endforeach

                    {{-- <option value="iot"
                        {{ isset($data->konsentrasi) && $data->konsentrasi == 'iot' ? 'selected' : '' }}>IOT</option>
                    <option value="ai"
                        {{ isset($data->konsentrasi) && $data->konsentrasi == 'ai' ? 'selected' : '' }}>Artificial
                        Intelligence</option>
                    <option value="ds"
                        {{ isset($data->konsentrasi) && $data->konsentrasi == 'ds' ? 'selected' : '' }}>Data Science
                    </option> --}}

                </select>
            </div>
        </div>
    </div>

    <div class="row g-9 mb-8">
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Objek Penelitian</label>
            <textarea data-kt-autosize="true" id="objek_penelitian" name="objek_penelitian" placeholder="Objek Penelitian"
                class="form-control">{{ isset($data->objek_penelitian) ? $data->objek_penelitian : null }}</textarea>
        </div>
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Latar Belakang Masalah</label>
            <textarea data-kt-autosize="true" id="latar_belakang" name="latar_belakang" placeholder="Latar Belakang Masalah"
                class="form-control">{{ isset($data->latar_belakang) ? $data->latar_belakang : null }}</textarea>
        </div>
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Rumusan Masalah</label>
            <textarea data-kt-autosize="true" id="rumusan_masalah" name="rumusan_masalah" placeholder="Latar Belakang Masalah"
                class="form-control">{{ isset($data->rumusan_masalah) ? $data->rumusan_masalah : null }}</textarea>
        </div>
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Latar Belakang Masalah</label>
            <textarea data-kt-autosize="true" id="tujuan_penelitian" name="tujuan_penelitian" placeholder="Latar Belakang Masalah"
                class="form-control">{{ isset($data->tujuan_penelitian) ? $data->tujuan_penelitian : null }}</textarea>
        </div>
        <div class="col-md-12 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Penelitian Terkait</label>
            <textarea data-kt-autosize="true" id="penelitian_terkait" name="penelitian_terkait" placeholder="Latar Belakang Masalah"
                class="form-control">{{ isset($data->penelitian_terkait) ? $data->penelitian_terkait : null }}</textarea>
        </div>
    </div>
    <!--end::Input group-->
</div>
