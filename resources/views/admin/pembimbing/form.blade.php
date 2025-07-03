@extends('admin._layouts.index')

{{-- @push('Data Master')
    here show
@endpush --}}

@push($title)
    active
@endpush

@section('content')
    <!--begin::Toolbar-->
    @component('admin._card.breadcrumb')
        @slot('header')
            {{ $title }}
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

            <!--begin::Tables Widget 10-->
            <div class="card mb-5 mb-xl-8">

                <!--begin::Header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Form {{ isset($data->id) ? 'Edit' : 'Input' }}</span>
                    </h3>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body pt-3">

                    <div class="row mt-5">
                        <!--begin:Form-->
                        <form id="kt_modal_new_target_form" class="form" action="#">
                            <input name="_method" type="hidden" id="methodId"
                                value="{{ isset($data->id) ? 'PUT' : 'POST' }}">
                            <input type="hidden" name="id" id="formId" value="{{ $data->id ?? null }}">
                            @csrf

                            <!--begin::Input group-->
                            <div class="row g-9 mb-8">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Dosen</label>
                                    <select class="form-select" data-control="select2" data-hide-search="true"
                                        data-placeholder="Select a Dosen" name="id_dosen" id="id_dosen">
                                        <option value="">Select user...</option>
                                        @foreach (Helper::getData('mst_dosens') as $v)
                                            <option {{ isset($data->nidn) && $data->nidn == $v->nidn ? 'selected' : '' }}
                                                value="{{ $v->nidn }}">{{ $v->nidn }} -
                                                {{ $v->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Judul Mahasiswa</label>
                                    <select class="form-select" data-control="select2" data-hide-search="true"
                                        data-placeholder="Select a Dosen" name="id_judul" id="id_judul">
                                        <option value="">Select user...</option>
                                        @foreach (Helper::getData('pengajuan_juduls') as $v)
                                            <option {{ isset($data->id) && $data->id == $v->id ? 'selected' : '' }}
                                                value="{{ $v->id }}">{{ $v->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <a href="{{ route($title . '.index') }}">
                                    <button type="button" id="kt_modal_new_target_cancel" class="btn btn-secondary me-3"
                                        data-bs-dismiss="modal">Batal</button>
                                </a>
                                @if (isset($data->id))
                                    <button type="submit" id="kt_modal_new_target_update" class="btn btn-primary">
                                        <span class="indicator-label">Update</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                @else
                                    <button type="submit" id="kt_modal_new_target_save" class="btn btn-primary">
                                        <span class="indicator-label">Simpan</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                @endif
                            </div>
                            <!--end::Actions-->

                        </form>
                        <!--end:Form-->
                    </div>

                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 10-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

@push('jsScriptForm')
    <script type="text/javascript">
        // Define form element
        const form = document.getElementById('kt_modal_new_target_form');

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form, {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Nama is required'
                            }
                        }
                    },
                    'code': {
                        validators: {
                            notEmpty: {
                                message: 'Kode is required'
                            }
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                },

            }
        );

        // $('#kt_docs_repeater_basic').repeater({
        //     initEmpty: false,

        //     defaultValues: {
        //         'text-input': 'foo'
        //     },

        //     show: function() {
        //         $(this).slideDown();

        //         $(this).find('.select2').select2({
        //             placeholder: "Pilih opsi",
        //             allowClear: true
        //         });
        //     },

        //     hide: function(deleteElement) {
        //         $(this).slideUp(deleteElement);
        //     },
        // });

        $('#kt_docs_repeater_basic').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();

                // Inisialisasi Select2 untuk elemen yang baru ditambahkan
                $(this).find('select[name*="nim"]').select2({
                    placeholder: "Select user...",
                    allowClear: true,
                    width: '100%'
                });

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
                placeholder: "Select user...",
                allowClear: true,
                width: '100%'
            });
        });

        // Fungsi untuk mengecek dan membatasi jumlah item
        function checkItemLimit() {
            const repeaterItems = $('#kt_docs_repeater_basic [data-repeater-item]');
            const addButton = $('#kt_docs_repeater_basic [data-repeater-create]');
            const maxItems = 2;

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



        // // proses save data
        // const submitButton = document.getElementById('kt_modal_new_target_save');
        // submitButton.addEventListener('click', function(e) {
        //     // Prevent default button action
        //     e.preventDefault();

        //     // Validate form before submit
        //     if (validator) {
        //         validator.validate().then(function(status) {
        //             if (status == 'Valid') {
        //                 // Show loading indication
        //                 submitButton.setAttribute('data-kt-indicator', 'on');
        //                 submitButton.disabled = true;
        //                 let formData = new FormData(kt_modal_new_target_form);

        //                 $.ajax({
        //                     headers: {
        //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                             'content')
        //                     },
        //                     data: formData,
        //                     url: "{{ route($title . '.store') }}",
        //                     type: "POST",
        //                     dataType: 'json',
        //                     processData: false,
        //                     contentType: false,
        //                     success: function(data) {
        //                         submitButton.removeAttribute('data-kt-indicator');
        //                         submitButton.disabled = false;
        //                         toastr.success("Successful save data!");
        //                         setTimeout(() => {
        //                             window.location.replace(
        //                                 "{{ route($title . '.index') }}"
        //                             );
        //                         }, 750);
        //                     },
        //                     error: function(data) {
        //                         submitButton.removeAttribute('data-kt-indicator');
        //                         submitButton.disabled = false;
        //                         console.log('Error:', data);
        //                         toastr.error("Failed to save data!");
        //                     }
        //                 });
        //             }
        //         });
        //     }
        // });
    </script>

    @if (isset($data->id))
        @include('admin._card._updateAjax')
    @else
        @include('admin._card._createAjax')
    @endif

@endpush
