<!-- resources/views/app/pengajuan-judul/form.blade.php -->
@extends('app.layouts.index')

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
                <div class="col-xl-12 mb-xl-10">
                    <div class="card h-xl-100">
                        <div class="card-body py-3 mt-5">
                            <!--begin::Stepper-->
                            <div class="stepper stepper-links d-flex flex-column" id="kt_stepper_pengajuan_judul">
                                <!--begin::Nav-->
                                <div class="stepper-nav">
                                    <div class="stepper-item current" data-kt-stepper-element="nav">
                                        <h3 class="stepper-title">Step 1 - Cek Judul</h3>
                                    </div>
                                    <div class="stepper-item" data-kt-stepper-element="nav">
                                        <h3 class="stepper-title">Step 2 - Data Penelitian</h3>
                                    </div>
                                    <div class="stepper-item" data-kt-stepper-element="nav">
                                        <h3 class="stepper-title">Step 3 - Review & Submit</h3>
                                    </div>
                                </div>
                                <!--end::Nav-->

                                <!--begin::Form-->
                                <form class="form" id="kt_stepper_pengajuan_judul_form" 
                                    action="{{ route('pengajuan-judul.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $uuid ?? null }}">

                                    <!--begin::Step 1-->
                                    <div data-kt-stepper-element="content">
                                        <div class="w-100">
                                            <div class="mb-10">
                                                <label class="form-label required">Judul Proposal</label>
                                                <div class="input-group">
                                                    <input type="text" name="judul" id="judul" 
                                                        class="form-control form-control-lg" 
                                                        placeholder="Masukkan judul penelitian" required
                                                        value="{{ old('judul') }}" />
                                                    <button type="button" id="checkTitleBtn" 
                                                        class="btn btn-primary" onclick="checkTitle(event)">
                                                        <span id="checkBtnText">Analisis Judul</span>
                                                    </button>
                                                </div>
                                                <div class="text-muted fs-7 mt-2">
                                                    Masukkan judul penelitian yang ingin diajukan
                                                </div>
                                            </div>

                                            <div id="titleCheckResult" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <!--end::Step 1-->

                                    <!--begin::Step 2-->
                                    <div data-kt-stepper-element="content">
                                        <div class="w-100">
                                            <div class="row mb-10">
                                                <div class="col-md-6">
                                                    <label class="form-label required">Topik Penelitian</label>
                                                    <input type="text" name="topik" id="topik" 
                                                        class="form-control" 
                                                        placeholder="Masukkan topik penelitian" required
                                                        value="{{ old('topik') }}" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Metodologi</label>
                                                    <select name="metodologi" class="form-select" required>
                                                        <option value="">Pilih Metodologi</option>
                                                        <option value="Kualitatif">Kualitatif</option>
                                                        <option value="Kuantitatif">Kuantitatif</option>
                                                        <option value="Campuran">Campuran</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-10">
                                                <label class="form-label required">Deskripsi Singkat</label>
                                                <textarea name="deskripsi" class="form-control" rows="5" 
                                                    placeholder="Deskripsi singkat tentang penelitian" required>{{ old('deskripsi') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Step 2-->

                                    <!--begin::Step 3-->
                                    <div data-kt-stepper-element="content">
                                        <div class="w-100">
                                            <h4 class="text-center mb-5">Review Data Pengajuan</h4>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="30%">Judul Proposal</th>
                                                        <td id="review-judul"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Topik Penelitian</th>
                                                        <td id="review-topik"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Metodologi</th>
                                                        <td id="review-metodologi"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Deskripsi Singkat</th>
                                                        <td id="review-deskripsi"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status Similarity</th>
                                                        <td id="review-similarity"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Step 3-->

                                    <!--begin::Actions-->
                                    <div class="d-flex flex-stack pt-15">
                                        <!--begin::Wrapper-->
                                        <div class="me-2">
                                            <button type="button" class="btn btn-lg btn-light-primary me-3" 
                                                data-kt-stepper-action="previous">
                                                <i class="ki-duotone ki-arrow-left fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Kembali
                                            </button>
                                        </div>
                                        <!--end::Wrapper-->

                                        <!--begin::Wrapper-->
                                        <div>
                                            <button type="button" class="btn btn-lg btn-primary" 
                                                data-kt-stepper-action="next">
                                                Lanjut <i class="ki-duotone ki-arrow-right fs-4 ms-1 me-0">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                            <button type="submit" class="btn btn-lg btn-success d-none" 
                                                id="kt_stepper_pengajuan_judul_submit">
                                                <i class="ki-duotone ki-check fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Submit
                                            </button>
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Stepper-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Post-->
    </div>
@endsection

@push('jsScript')
<script>
    // Inisialisasi stepper
    const stepper = new KTStepper(document.getElementById('kt_stepper_pengajuan_judul'));
    console.log(stepper);

    // Handle next step
    stepper.on('kt.stepper.next', function (stepper) {
        // Validasi sebelum lanjut ke step berikutnya
        if (stepper.currentStepIndex === 0) {
            const judul = $('input[name="judul"]').val();
            if (!judul) {
                toastr.error("Judul harus diisi!");
                return false;
            }
            
            const resultDiv = document.getElementById('titleCheckResult');
            if (resultDiv.style.display === 'none') {
                toastr.error("Silakan lakukan analisis judul terlebih dahulu");
                return false;
            }
        } else if (stepper.currentStepIndex === 0) {
            // Validasi step 2
            if (!$('input[name="topik"]').val() || !$('select[name="metodologi"]').val() || 
                !$('textarea[name="deskripsi"]').val()) {
                toastr.error("Lengkapi semua data pada step ini!");
                return false;
            }
            
            // Tampilkan data review di step 3
            $('#review-judul').text($('input[name="judul"]').val());
            $('#review-topik').text($('input[name="topik"]').val());
            $('#review-metodologi').text($('select[name="metodologi"] option:selected').text());
            $('#review-deskripsi').text($('textarea[name="deskripsi"]').val());
            
            // Tampilkan hasil similarity
            const resultDiv = document.getElementById('titleCheckResult');
            if (resultDiv) {
                $('#review-similarity').html(resultDiv.innerHTML);
            }
        }
        
        stepper.goNext();
    });

    // Handle previous step
    stepper.on('kt.stepper.previous', function (stepper) {
        stepper.goPrevious();
    });

    // Handle submit form
    $('#kt_stepper_pengajuan_judul_form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const url = form.attr('action');
        const formData = form.serialize();
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                KTApp.showPageLoading();
                $('#kt_stepper_pengajuan_judul_submit').prop('disabled', true);
            },
            success: function(response) {
                KTApp.hidePageLoading();
                
                if (response.success) {
                    toastr.success(response.message || "Data berhasil disimpan!");
                    
                    // Redirect setelah 2 detik
                    setTimeout(function() {
                        window.location.href = response.redirect || '{{ route("dashboard") }}';
                    }, 2000);
                } else {
                    toastr.error(response.message || "Terjadi kesalahan saat menyimpan data");
                    $('#kt_stepper_pengajuan_judul_submit').prop('disabled', false);
                }
            },
            error: function(xhr) {
                KTApp.hidePageLoading();
                $('#kt_stepper_pengajuan_judul_submit').prop('disabled', false);
                
                let errorMessage = "Terjadi kesalahan saat menyimpan data";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = "";
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errorMessage += value + "<br>";
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                toastr.error(errorMessage);
            }
        });
    });

    // Tampilkan tombol submit di step terakhir
    stepper.on('kt.stepper.changed', function(stepper) {
        if (stepper.currentStepIndex === stepper.totalStepsNumber - 1) {
            $('[data-kt-stepper-action="next"]').addClass('d-none');
            $('#kt_stepper_pengajuan_judul_submit').removeClass('d-none');
        } else {
            $('[data-kt-stepper-action="next"]').removeClass('d-none');
            $('#kt_stepper_pengajuan_judul_submit').addClass('d-none');
        }
    });

    // Fungsi checkTitle dari kode sebelumnya tetap sama
    async function checkTitle(event) {
        // ... (kode checkTitle yang sudah ada)
    }

    function displayAnalysisResult(data) {
        // ... (kode displayAnalysisResult yang sudah ada)
    }

    function resetTitleCheck() {
        // ... (kode resetTitleCheck yang sudah ada)
    }

    function getRecommendations(similarTitles = []) {
        // ... (kode getRecommendations yang sudah ada)
    }

    // Initialize with saved title if exists
    document.addEventListener('DOMContentLoaded', function() {
        const savedJudul = localStorage.getItem('saved_judul');
        if (savedJudul) {
            document.getElementById('judul').value = savedJudul;
        }

        document.getElementById('judul').addEventListener('input', function() {
            localStorage.setItem('saved_judul', this.value);
        });
    });
</script>
@endpush