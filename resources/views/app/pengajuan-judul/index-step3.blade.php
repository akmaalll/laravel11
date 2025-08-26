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
                                            id="backStep2">
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
        let nim1 = "{{ Session::get('stb', '') }}"; // Ambil NIM1 dari session

        // Fungsi validasi NIM
        function validateNim2(nim2) {
            // Validasi panjang 6 digit
            if (nim2.length !== 6) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid NIM',
                    text: 'NIM harus 6 digit!'
                });
                return false;
            }

            // Validasi digit ke-3 harus sama dengan NIM1
            if (nim1.length >= 3 && nim2.length >= 3) {
                if (nim1[2] !== nim2[2]) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid NIM',
                        html: `Digit ke-3 NIM harus sama dengan NIM pertama!<br>
                           NIM1: ${nim1} (digit ke-3 = ${nim1[2]})<br>
                           NIM2: ${nim2} (digit ke-3 = ${nim2[2]})`
                    });
                    return false;
                }
            }

            return true;
        }

        // Event saat form disubmit
        $('form').on('submit', function(e) {
            const nim2 = $('#nim2').val();

            if (nim2 && !validateNim2(nim2)) {
                e.preventDefault(); // Hentikan submit jika tidak valid
                return false;
            }
        });

        // Event saat select berubah (validasi real-time)
        $('#nim2').on('change', function() {
            const nim2 = $(this).val();
            if (nim2) {
                validateNim2(nim2);
            }
        });

        $(document).ready(function() {
            let mahasiswaList = [];

            // Ambil data mahasiswa dari API
            fetch('/api/mahasiswa-list')
                .then(response => response.json())
                .then(result => {
                    mahasiswaList = result.data.map(m => ({
                        id: m.stb,
                        text: m.stb + ' - ' + m.nmmhs,
                        nama: m.nmmhs
                    }));

                    // Inisialisasi select2 khusus untuk Mahasiswa 2
                    $('#nim2').select2({
                        data: mahasiswaList,
                        placeholder: "Pilih Mahasiswa...",
                        allowClear: true,
                        width: '100%'
                    });

                    // Set nilai default jika ada (optional)
                    @if (isset($data->nim2))
                        $('#nim2').val("{{ $data->nim2 }}").trigger('change');
                        const selected = mahasiswaList.find(m => m.id == "{{ $data->nim2 }}");
                        if (selected) {
                            $('#nama_mahasiswa2').val(selected.nama);
                        }
                    @endif
                });

            // Event saat select Mahasiswa 2 berubah
            $('#nim2').on('change', function() {
                const selectedNim = $(this).val();
                if (selectedNim) {
                    if (!validateNim2(selectedNim)) {
                        $(this).val('').trigger('change'); // Reset pilihan jika tidak valid
                    } else {
                        const selected = mahasiswaList.find(m => m.id === selectedNim);
                        $('#nama_mahasiswa2').val(selected ? selected.nama : '');
                    }
                }
            });
        });

        $(document).ready(function() {

            $('#backStep2').on('click', function() {
                setTimeout(function() {
                    window.location.replace("{{ route('pengajuan.step2') }}");
                }, 750);
            });


        })
    </script>
@endpush
