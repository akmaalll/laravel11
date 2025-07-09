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
                            <input type="hidden" name="id_user" value="1">
                            @csrf

                            <!--begin::Input group-->
                            <div class="row g-9 mb-8">
                                <div class="col-md-6">
                                    <div class="col-md-12 fv-row">
                                        <label class="required fs-6 fw-semibold mb-2">Judul</label>
                                        <textarea data-kt-autosize="true" id="judul" name="judul" placeholder="Judul" class="form-control mb-3">{{ $data->judul ?? '' }}</textarea>

                                        <button type="button" id="classifyTopicBtn" class="btn btn-primary mb-3">
                                            <span class="indicator-label">Klasifikasi Topik</span>
                                            <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>

                                        {{-- <!-- Alert untuk menampilkan hasil klasifikasi -->
                                        <div id="classificationResult" class="alert alert-info d-none" role="alert">
                                            <h6 class="alert-heading">Hasil Klasifikasi:</h6>
                                            <p id="classificationMessage" class="mb-0"></p>
                                        </div>

                                        <!-- Alert untuk menampilkan judul serupa -->
                                        <div id="similarTitlesResult" class="alert alert-warning d-none" role="alert">
                                            <h6 class="alert-heading">Judul Serupa Ditemukan:</h6>
                                            <div id="similarTitlesList"></div>
                                        </div> --}}
                                    </div>

                                    <div class="col-md-12 fv-row">
                                        <label class="required fs-6 fw-semibold mb-2">Topik</label>
                                        <input type="text" class="form-control"
                                            placeholder="Topik akan diisi otomatis setelah klasifikasi" name="topik"
                                            id="topik" value="{{ $data->topik ?? '' }}" readonly />
                                        <small class="form-text text-muted">Topik akan diisi otomatis berdasarkan hasil
                                            klasifikasi judul</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 fv-row">
                                        <label class="required fs-6 fw-semibold mb-2">Topik</label>
                                        <select class="form-select" data-control="select2" data-hide-search="true"
                                            data-placeholder="Select a Keahlian" name="id_prodi" id="id_prodi" readonly>
                                            <option value="">Select user...</option>
                                            @foreach (Helper::getData('mst_prodis') as $v)
                                                <option value="{{ $v->id }}"
                                                    @if (isset($data->id_prodi) && $data->id_prodi == $v->id) selected
                            @elseif(!isset($data->id_prodi) && Session::get('prodi_kode') == $v->kode)
                                selected @endif>
                                                    {{ $v->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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

@push('jsScript')
    <script type="text/javascript">
        // Define form element
        const form = document.getElementById('kt_modal_new_target_form');

        // Init form validation rules
        var validator = FormValidation.formValidation(
            form, {
                fields: {
                    'judul': {
                        validators: {
                            notEmpty: {
                                message: 'Judul is required'
                            },
                            stringLength: {
                                min: 10,
                                message: 'Judul minimal 10 karakter'
                            }
                        }
                    },
                    'topik': {
                        validators: {
                            notEmpty: {
                                message: 'Topik is required'
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

        // Fungsi untuk klasifikasi topik
        document.getElementById('classifyTopicBtn').addEventListener('click', function(e) {
            e.preventDefault();

            const judul = document.getElementById('judul').value.trim();
            const button = this;

            if (!judul) {
                toastr.error('Silakan masukkan judul terlebih dahulu');
                return;
            }

            if (judul.length < 10) {
                toastr.error('Judul minimal 10 karakter');
                return;
            }

            // Show loading
            button.setAttribute('data-kt-indicator', 'on');
            button.disabled = true;

            // Hide previous results
            // document.getElementById('classificationResult').classList.add('d-none');
            // document.getElementById('similarTitlesResult').classList.add('d-none');

            // AJAX request to classify topic
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('check.title.similarity') }}",
                type: "POST",
                data: {
                    judul: judul
                },
                dataType: 'json',
                success: function(response) {
                    // Hide loading
                    button.removeAttribute('data-kt-indicator');
                    button.disabled = false;

                    // Show classification result
                    const resultDiv = document.getElementById('classificationResult');
                    const messageDiv = document.getElementById('classificationMessage');

                    if (response.status === 'success') {
                        // resultDiv.className = 'alert alert-success';
                        // messageDiv.innerHTML = `
                    //     <strong>Topik Diprediksi:</strong> ${response.predicted_topic}<br>
                    //     <strong>Tingkat Kemiripan:</strong> ${(response.similarity * 100).toFixed(2)}%<br>
                    //     <strong>Status:</strong> ${response.message}
                    // `;

                        // Set topik otomatis
                        document.getElementById('topik').value = response.predicted_topic;

                        toastr.success('Klasifikasi berhasil! Topik telah diisi otomatis.');

                    } else if (response.status === 'warning') {
                        // resultDiv.className = 'alert alert-warning';
                        // messageDiv.innerHTML = `
                    //     <strong>Peringatan:</strong> ${response.validation_message}<br>
                    //     ${response.predicted_topic ? `<strong>Topik Diprediksi:</strong> ${response.predicted_topic}<br>` : ''}
                    //     <strong>Tingkat Kemiripan:</strong> ${(response.similarity * 100).toFixed(2)}%
                    // `;

                        // if (response.predicted_topic) {
                        //     document.getElementById('topik').value = response.predicted_topic;
                        // }

                        toastr.warning(response.message);
                    }

                    resultDiv.classList.remove('d-none');

                    // Show similar titles if any
                    if (response.similar_titles && response.similar_titles.length > 0) {
                        const similarDiv = document.getElementById('similarTitlesResult');
                        const similarList = document.getElementById('similarTitlesList');

                        let similarHtml = '<ul class="mb-0">';
                        response.similar_titles.forEach(function(title) {
                            similarHtml += `
                                <li>
                                    <strong>${title.judul}</strong> 
                                    (${title.topik}) - 
                                    Kemiripan: ${(title.similarity * 100).toFixed(2)}%
                                </li>
                            `;
                        });
                        similarHtml += '</ul>';

                        similarList.innerHTML = similarHtml;
                        similarDiv.classList.remove('d-none');
                    }
                },
                error: function(xhr) {
                    // Hide loading
                    button.removeAttribute('data-kt-indicator');
                    button.disabled = false;

                    console.log('Error:', xhr);
                    let errorMessage = 'Terjadi kesalahan saat klasifikasi topik';

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    toastr.error(errorMessage);
                }
            });
        });

        // Reset classification results when title changes
        document.getElementById('judul').addEventListener('input', function() {
            // document.getElementById('classificationResult').classList.add('d-none');
            // document.getElementById('similarTitlesResult').classList.add('d-none');
            document.getElementById('topik').value = '';
        });
    </script>

    @if (isset($data->id))
        @include('admin._card._updateAjax')
    @else
        @include('admin._card._createAjax')
    @endif

@endpush
