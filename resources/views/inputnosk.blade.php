@extends('admin._layouts.index')

@push($title)
    active
@endpush

@section('content')
    <!--begin::Toolbar-->
    @component('admin._card.breadcrumb')
        @slot('header')
            Input Nomor Surat SK Pembimbing
        @endslot
        @slot('page')
            Form
        @endslot
    @endcomponent
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Input Nomor Surat SK Pembimbing</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Masukkan nomor surat untuk dokumen SK
                            Pembimbing</span>
                    </h3>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body pt-3">
                    <!--begin::Alert-->
                    <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                        <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                    fill="currentColor" />
                                <path
                                    d="M21 5H2.99999C2.69999 5 2.49999 5.10000 2.29999 5.30000L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30000C21.5 5.10000 21.3 5 21 5Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-primary">Informasi</h4>
                            <span>Silakan masukkan nomor surat untuk SK Pembimbing. Nomor surat akan ditampilkan pada
                                dokumen PDF yang dihasilkan.</span>
                        </div>
                    </div>
                    <!--end::Alert-->

                    <div class="row mt-5">
                        <!--begin:Form-->
                        <form id="kt_modal_nomor_surat_form" class="form" action="{{ route('sk-pembimbing.pdf', $id) }}"
                            method="POST">
                            @csrf

                            <!--begin::Input group-->
                            <div class="row g-9 mb-8">
                                <div class="col-md-12 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Nomor Surat</label>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="Contoh: 123/UNDIPA/AK/VI/2023" name="nomor_surat" id="nomor_surat"
                                        value="{{ old('nomor_surat') }}" required />
                                    <div class="text-muted fs-7 mt-1">Format: Nomor/UNDIPA/Unit/Bulan/Tahun</div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Preview section-->
                            <div class="separator separator-dashed my-10"></div>

                            <div class="mb-10">
                                <h4 class="text-gray-800 mb-4">Pratinjau Surat</h4>
                                <div class="bg-light rounded p-5">
                                    <div class="text-center">
                                        <p class="fw-bold fs-5 mb-1">SURAT KEPUTUSAN</p>
                                        <p class="fw-bold fs-5 mb-1">REKTOR UNIVERSITAS DIPA MAKASSAR</p>
                                        <p class="fs-6 mb-3">Nomor: <span id="preview-nomor"
                                                class="fw-semibold">{{ old('nomor_surat', '.../UNDIPA/.../.../....') }}</span>
                                        </p>
                                        <p class="fw-bold fs-6 mb-1">Tentang</p>
                                        <p class="fw-bold fs-6">PENGANGKATAN DOSEN PEMBIMBING TUGAS AKHIR / SKRIPSI</p>
                                    </div>
                                </div>
                            </div>
                            <!--end::Preview section-->

                            <!--begin::Format info-->
                            <div
                                class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6 mb-10">
                                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                            fill="currentColor" />
                                        <rect x="11" y="14" width="7" height="2" rx="1"
                                            transform="rotate(-90 11 14)" fill="currentColor" />
                                        <rect x="11" y="17" width="2" height="2" rx="1"
                                            transform="rotate(-90 11 17)" fill="currentColor" />
                                    </svg>
                                </span>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <h4 class="text-gray-800 fw-bold">Format Nomor Surat</h4>
                                        <div class="fs-6 text-gray-600">
                                            <p>Nomor surat biasanya terdiri dari:</p>
                                            <ul class="mb-0">
                                                <li>Nomor urut (contoh: 123)</li>
                                                <li>Kode institusi (contoh: UNDIPA)</li>
                                                <li>Kode unit/fakultas (contoh: AK untuk Akademik)</li>
                                                <li>Bulan dalam angka Romawi (contoh: VI untuk Juni)</li>
                                                <li>Tahun (contoh: 2023)</li>
                                            </ul>
                                            <p class="mt-2 mb-0"><strong>Contoh: 123/UNDIPA/AK/VI/2023</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Format info-->

                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <a href="{{ url()->previous() }}" class="btn btn-light me-3">Batal</a>
                                <button type="submit" id="kt_modal_nomor_surat_submit" class="btn btn-primary">
                                    <span class="indicator-label">Simpan & Generate PDF</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end:Form-->
                    </div>
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

@push('jsScriptForm')
    <script type="text/javascript">
        // Update preview ketika input berubah
        document.getElementById('nomor_surat').addEventListener('input', function() {
            document.getElementById('preview-nomor').textContent = this.value || '.../UNDIPA/.../.../....';
        });

        // Form validation
        const form = document.getElementById('kt_modal_nomor_surat_form');
        const submitButton = document.getElementById('kt_modal_nomor_surat_submit');

        // Init form validation rules
        var validator = FormValidation.formValidation(
            form, {
                fields: {
                    'nomor_surat': {
                        validators: {
                            notEmpty: {
                                message: 'Nomor surat harus diisi'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Handle form submission
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            // Validate form before submit
            validator.validate().then(function(status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    // Submit the form
                    form.submit();
                } else {
                    // Show error message
                    Swal.fire({
                        text: "Maaf, terdapat kesalahan input. Silakan periksa kembali form Anda.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    </script>
@endpush
