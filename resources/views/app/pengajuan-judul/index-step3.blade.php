@extends('app.layouts.index', ['pengajuan_judul' => true])

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">Pengajuan Judul
                    <span class="h-20px border-gray-500 border-start mx-3"></span>
                    <small class="text-gray-500 fs-7 fw-semibold my-1">Form</small>
                </h1>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">

            <div class="row g-5 g-lg-10">
                <!--begin::Col-->
                <div class="col-xl-12 mb-xl-10">
                    <!--begin::Tables Widget 3-->
                    <div class="card h-xl-100">
                        <!--begin::Body-->
                        <div class="card-body py-3 mt-5">

                            <!--begin::Step-->
                            @include('app.pengajuan-judul._stepHeader')
                            <!--end::Step-->

                            <!--begin::Form-->
                            <form class="form" id="kt_formvalidation_step" action="#" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="step" name="step" value="{{ $currentStep ?? 3 }}">
                                <input type="hidden" name="id" id="formId" value="{{ $uuid ?? null }}">

                                <div class="mb-5">
                                    <!--begin::Step 1-->
                                    @include('app.pengajuan-judul._step3')
                                    <!--End::Step 1-->
                                </div>

                                <div class="separator separator-dashed my-10"></div>

                                <!--begin::Actions-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Wrapper-->
                                    <div class="me-2">
                                        <button type="button" class="btn btn-light btn-active-light-primary"
                                            id="backStep1">
                                            <- Back </button>
                                    </div>
                                    <!--end::Wrapper-->

                                    <!--begin::Wrapper-->
                                    <button type="button" id="kt_formvalidation_step_submit"
                                        class="btn btn-primary kt_formvalidation_step_submit" data-id="Submit">
                                        <span class="indicator-label">Submit -></span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form-->

                        </div>
                        <!--begin::Body-->
                    </div>
                    <!--end::Tables Widget 3-->
                </div>
                <!--end::Col-->

            </div>
            <!--end::Row-->

        </div>
        <!--end::Post-->
    </div>
@endsection

@push('jsScript')
    @include('app.pengajuan-judul.js.submitAndDraf')
    <script>
        let mahasiswaList = [];
        $(document).ready(function() {
            // Ambil data mahasiswa dari API
            fetch('/api/mahasiswa-list')
                .then(response => response.json())
                .then(result => {
                    mahasiswaList = result.data.map(m => ({
                        id: m.stb,
                        text: m.stb + ' - ' + m.nmmhs,
                        nama: m.nmmhs
                    }));

                    // Inisialisasi select2 untuk semua select-mahasiswa
                    $('.select-mahasiswa').each(function(index) {
                        $(this).select2({
                            data: mahasiswaList,
                            placeholder: "Pilih Mahasiswa...",
                            allowClear: true,
                            width: '100%'
                        });
                        // Jika item pertama (login), set value default dan readonly
                        if (index === 0) {
                            var nimLogin = "{{ Session::get('stb', '') }}";
                            var namaLogin = "{{ Session::get('nama_mhs', '') }}";
                            $(this).val(nimLogin).trigger('change');
                            $(this).prop('disabled', true);
                            $(this).closest('[data-repeater-item]').find('.nama-mahasiswa').val(
                                namaLogin);
                            // Sembunyikan tombol delete pada item pertama
                            $(this).closest('[data-repeater-item]').find('[data-repeater-delete]')
                            .hide();
                        }
                    });
                });

            // Event saat select berubah, isi nama otomatis
            $(document).on('change', '.select-mahasiswa', function() {
                const selectedNim = $(this).val();
                const selected = mahasiswaList.find(m => m.id === selectedNim);
                $(this).closest('[data-repeater-item]').find('.nama-mahasiswa').val(selected ? selected
                    .nama : '');
            });
        });

        $('#kt_docs_repeater_basic').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();

                // Inisialisasi Select2 untuk elemen yang baru ditambahkan
                $(this).find('select[name*="nim"]').select2({
                    data: mahasiswaList,
                    placeholder: "Pilih Mahasiswa...",
                    allowClear: true,
                    width: '100%'
                });

                // Jika ini item pertama (login), set value default dan readonly
                if ($('#kt_docs_repeater_basic [data-repeater-item]').length === 1) {
                    var nimLogin = "{{ Session::get('stb', '') }}";
                    var namaLogin = "{{ Session::get('nama_mhs', '') }}";
                    $(this).find('select[name*="nim"]').val(nimLogin).trigger('change');
                    $(this).find('select[name*="nim"]').prop('disabled', true);
                    $(this).find('.nama-mahasiswa').val(namaLogin);
                    $(this).find('[data-repeater-delete]').hide();
                } else {
                    // Pastikan select NIM kosong saat baru ditambah
                    $(this).find('select[name*="nim"]').val(null).trigger('change');
                    $(this).find('select[name*="nim"]').prop('disabled', false);
                    $(this).find('[data-repeater-delete]').show();
                }

                // Cek jumlah item setelah menambah
                checkItemLimit();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);

                setTimeout(function() {
                    checkItemLimit();
                }, 500);
            },

        });

        // Inisialisasi Select2 untuk item yang sudah ada
        $('#kt_docs_repeater_basic select[name*="nim"]').each(function() {
            $(this).select2({
                data: mahasiswaList,
                placeholder: "Pilih Mahasiswa...",
                allowClear: true,
                width: '100%'
            });
        });

        // Fungsi untuk mengecek dan membatasi jumlah item
        function checkItemLimit() {
            // Hanya hitung item pada repeater (mahasiswa tambahan)
            const repeaterItems = $('#kt_docs_repeater_basic [data-repeater-item]');
            const addButton = $('#kt_docs_repeater_basic [data-repeater-create]');
            const maxItems = 2; // hanya boleh tambah 1 mahasiswa tambahan

            if (repeaterItems.length >= maxItems) {
                addButton.hide();
            } else {
                addButton.show();
            }
        }

        // Jalankan pengecekan limit saat halaman pertama kali dimuat
        $(document).ready(function() {
            checkItemLimit();
        });
    </script>
@endpush
