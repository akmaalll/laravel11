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

                    {{-- @if (isset($rekomendasi) && count($rekomendasi) > 0)
                        <div class="alert alert-info">
                            <strong>Rekomendasi Pembimbing (Naive Bayes):</strong>
                            <ol>
                                @foreach ($rekomendasi as $nidn => $rec)
                                    <li><b>{{ $rec['nama'] }}</b> (NIDN: {{ $nidn }}) - Skor:
                                        {{ number_format($rec['skor'], 4) }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif --}}

                    <div class="row mt-5">
                        <!--begin:Form-->
                        <form id="kt_modal_new_target_form" class="form" method="POST"
                            action="{{ route('pembimbing.assign-with-recommendation', $pengajuan->id ?? ($pengajuan_id ?? null)) }}">
                            @csrf
                            <input type="hidden" name="pengajuan_id"
                                value="{{ $pengajuan->id ?? ($pengajuan_id ?? null) }}">
                            <div class="row g-9 mb-8">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Pembimbing 1 (15 teratas)</label>
                                    <select class="form-select" data-control="select2" data-hide-search="true"
                                        data-placeholder="Select a Dosen" name="pembimbing_1" id="pembimbing_1" required>
                                        <option value="">Pilih Pembimbing 1...</option>
                                        @if (isset($rekomendasi) && count($rekomendasi) > 0)
                                            @foreach (array_slice($rekomendasi, 0, 15) as $nidn => $rec)
                                                <option value="{{ $nidn }}">{{ $rec['nama'] }}
                                                    ({{ $nidn }})
                                                    - Skor: {{ number_format($rec['skor'], 4) }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Pembimbing 2 (selain 15 teratas)</label>
                                    <select class="form-select" data-control="select2" data-hide-search="true"
                                        data-placeholder="Select a Dosen" name="pembimbing_2" id="pembimbing_2" required>
                                        <option value="">Pilih Pembimbing 2...</option>
                                        @if (isset($rekomendasi) && count($rekomendasi) > 0)
                                            @foreach (array_slice($rekomendasi, 15) as $nidn => $rec)
                                                <option value="{{ $nidn }}">{{ $rec['nama'] }}
                                                    ({{ $nidn }})
                                                    - Skor: {{ number_format($rec['skor'], 4) }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route($title . '.index') }}">
                                    <button type="button" id="kt_modal_new_target_cancel" class="btn btn-secondary me-3"
                                        data-bs-dismiss="modal">Batal</button>
                                </a>
                                <button type="submit" id="kt_modal_new_target_save" class="btn btn-primary">
                                    <span class="indicator-label">Simpan</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
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
        {{-- @include('admin._card._createAjax') --}}
        
    @endif

    <script>
        // Exclude pembimbing 1 dari pembimbing 2
        document.addEventListener('DOMContentLoaded', function() {
            const pembimbing1 = document.getElementById('pembimbing_1');
            const pembimbing2 = document.getElementById('pembimbing_2');
            pembimbing1.addEventListener('change', function() {
                const selected1 = this.value;
                Array.from(pembimbing2.options).forEach(opt => {
                    if (opt.value === selected1 && opt.value !== '') {
                        opt.disabled = true;
                    } else {
                        opt.disabled = false;
                    }
                });
            });
        });
    </script>

@endpush
