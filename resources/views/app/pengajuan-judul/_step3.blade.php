<div class="flex-column">
    <!--begin::Input group-->
    <div class="row g-9 mb-8">
        <label class="fs-5 fw-bold">1.1 Identitas Usulan Penelitian</label>

        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">1. Judul</label>
            <textarea data-kt-autosize="true" id="judul" name="" placeholder="Judul" class="form-control" cols="10"
                rows="5" readonly>
               {{ str_replace(['<br>', "\n", "\r"], '', $data['judul'] ?? null) }}
            </textarea>
        </div>
        <div class=" col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">2. Deskripsi</label>
            <textarea data-kt-autosize="true" id="" name="" placeholder="Judul" class="form-control" cols="10"
                rows="5">
               {{ str_replace(['<br>', "\n", "\r"], '', $data['deskripsi'] ?? null) }}
            </textarea>

        </div>
    </div>
    <div class="row g-9 mb-8">
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">3. Topik</label>
            <input type="text" class="form-control form-control-solid" placeholder="" name=""
                value="{{ $data['topik'] }}" id="" readonly />
        </div>
        {{-- <div class=" col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">2. Topik</label>
            <input type="text" class="form-control form-control-solid" placeholder="" name=""
                value="{{ $data['topik'] }}" id="" readonly />
        </div> --}}
    </div>

    {{-- <div class="row g-9 mb-8">
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">NIM</label>
            <input type="text" class="form-control form-control-solid" placeholder="" name="nim"
                value="{{ Session::get('stb', '') }}" id="nim" readonly/>
        </div>
    </div> --}}
    {{-- <div class="form-group row mb-4">
        <div class="col-md-3">
            <label class="required fs-6 fw-semibold mb-2">Nim Mahasiswa</label>
            <input type="text" class="form-control" name="mahasiswas[0][nim]" value="{{ Session::get('stb', '') }}"
                readonly>
        </div>
        <div class="col-md-6">
            <label class="required fs-6 fw-semibold mb-2">Nama Mahasiswa</label>
            <input type="text" class="form-control" name="mahasiswas[0][nama]"
                value="{{ Session::get('nama_mhs', '') }}" readonly>
        </div>
    </div> --}}
    <div class="row g-9 mb-8">
        <div class="col-md-12 fv-row">
            <!--begin::Repeater-->
            <div id="kt_docs_repeater_basic">
                <!--begin::Form group-->
                <div class="form-group">
                    <div data-repeater-list="mahasiswas">
                        <div data-repeater-item>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="required fs-6 fw-semibold mb-2">Nim Mahasiswa</label>
                                    <input type="hidden" name="nim" value="{{ Session::get('stb', '') }}">
                                    <select class="form-control select-mahasiswa" name="nim" value="{{ Session::get('stb', '') }}" readonly></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">Nama Mahasiswa</label>
                                    <input type="text" class="form-control nama-mahasiswa" name="nama" value="{{ Session::get('nama_mhs', '') }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <a href="javascript:;" data-repeater-delete
                                        class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                        <i class="ki-duotone ki-trash fs-5"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Form group-->

                <!--begin::Form group-->
                <div class="form-group mt-5">
                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                        <i class="ki-duotone ki-plus fs-3"></i> Add
                    </a>
                </div>
                <!--end::Form group-->
            </div>
            <!--end::Repeater-->
        </div>
    </div>
    <!--end::Input group-->
</div>
