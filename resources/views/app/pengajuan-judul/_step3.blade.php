<div class="flex-column">
    <!--begin::Input group-->
    <div class="row g-9 mb-8">
        <label class="fs-5 fw-bold">1.1 Identitas Usulan Penelitian</label>

        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">1. Judul</label>
            <textarea data-kt-autosize="true" id="judul" name="" placeholder="Judul" class="form-control"
                data-kt-autosize="true" readonly>
{{ trim(str_replace(['<br>', "\n", "\r"], '', $data->judul ?? '')) }}
</textarea>

        </div>
        <div class=" col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">2. Prodi</label>
            <input type="text" class="form-control form-control-solid" placeholder="" name=""
                value="{{ $data->nama_prodi }}" id="" readonly />
        </div>
    </div>
    <div class="row g-9 mb-8">
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">3. Topik</label>
            <input type="text" class="form-control form-control-solid" placeholder="" name=""
                value="{{ $data->nama_keahlian }}" id="" readonly />
        </div>
        <div class=" col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2"> Mahasiswa 1</label>
            <input type="text" class="form-control form-control-solid" placeholder="" name=""
                value="{{ $data->nim1 }} - {{ $nama }}" id="" readonly />
        </div>
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Mahasiswa 2</label>
            <select class="form-control form-control-solid select2-mahasiswa" name="nim2" id="nim2">
                <option value="">Pilih Mahasiswa...</option>
            </select>
            <input type="hidden" name="nama_mahasiswa2" id="nama_mahasiswa2">
        </div>
    </div>
    <!--end::Input group-->
</div>
