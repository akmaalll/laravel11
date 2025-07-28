@extends('admin._layouts.index')

@push('pembimbing')
    active
@endpush

@section('content')
    <!--begin::Toolbar-->
    @component('admin._card.breadcrumb')
        @slot('header')
            Assignment Pembimbing
        @endslot
        @slot('page')
            Assignment dengan Rekomendasi AI
        @endslot
    @endcomponent
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Card-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-robot text-primary me-2"></i>
                        Assignment Pembimbing dengan Rekomendasi Naive Bayes
                    </h3>
                </div>
                <div class="card-body">

                    <!-- Form Pilih Pengajuan -->
                    <div class="row mb-5">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="pengajuan_select" class="form-label fw-bold">Pilih Pengajuan Judul:</label>
                                <select class="form-select" data-control="select2" data-hide-search="true"
                                    id="pengajuan_select">
                                    @foreach (Helper::getData('pengajuan_juduls') as $pengajuan)
                                        <option value="{{ $pengajuan->id }}">{{ $pengajuan->judul }}
                                            ({{ $pengajuan->topik }})
                                            - {{ $pengajuan->status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="button" class="btn btn-primary btn-lg" onclick="getRecommendations()">
                                        <i class="fas fa-magic me-2"></i>Dapatkan Rekomendasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loading -->
                    <div id="loading-section" style="display: none;" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-3">Menganalisis dan memberikan rekomendasi...</p>
                    </div>

                    <!-- Error Message -->
                    <div id="error-section" style="display: none;" class="alert alert-danger">
                    </div>

                    <!-- Hasil Rekomendasi -->
                    <div id="recommendation-section" style="display: none;">

                        <!-- Info Pengajuan -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card card-custom mb-6">
                                    <div class="card-header bg-light-primary">
                                        <div class="card-title">
                                            <i class="ki-duotone ki-document fs-2 text-primary me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <h6 class="mb-0">Informasi Pengajuan</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row" id="pengajuan-info">
                                            <!-- Info akan diisi oleh JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rekomendasi AI -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card card-custom mb-6">
                                    <div class="card-header bg-light-success">
                                        <div class="card-title">
                                            <i class="ki-duotone ki-brain fs-2 text-success me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <h6 class="mb-0">Rekomendasi AI (Naive Bayes)</h6>
                                        </div>
                                        <div class="card-toolbar">
                                            <span class="badge badge-light-success fs-7">
                                                <i class="ki-duotone ki-information-5 fs-6 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                Keahlian (40%) | Bimbingan (40%) | Penelitian (20%)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row" id="recommendation-cards">
                                            <!-- Cards akan diisi oleh JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Assignment -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-custom">
                                    <div class="card-header bg-light-warning">
                                        <div class="card-title">
                                            <i class="ki-duotone ki-user-square fs-2 text-warning me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <h6 class="mb-0">Assignment Pembimbing</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form id="assignment-form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label for="pembimbing1" class="form-label fw-bold text-dark">
                                                            <i class="ki-duotone ki-user fs-6 text-primary me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            Pembimbing 1
                                                        </label>
                                                        <select id="pembimbing1" name="pembimbing1_id"
                                                            class="form-select form-select-solid" data-control="select2"
                                                            data-placeholder="Pilih Pembimbing 1..." required>
                                                            <option value="">Pilih Pembimbing 1...</option>
                                                        </select>
                                                        <small class="text-muted">Pilih dari rekomendasi AI atau dosen
                                                            lainnya</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label for="pembimbing2" class="form-label fw-bold text-dark">
                                                            <i class="ki-duotone ki-user fs-6 text-success me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            Pembimbing 2
                                                        </label>
                                                        <select id="pembimbing2" name="pembimbing2_id"
                                                            class="form-select form-select-solid" data-control="select2"
                                                            data-placeholder="Pilih Pembimbing 2..." required>
                                                            <option value="">Pilih Pembimbing 2...</option>
                                                        </select>
                                                        <small class="text-muted">Pilih dari rekomendasi AI atau dosen
                                                            lainnya</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mb-4">
                                                        <label for="assignment_notes"
                                                            class="form-label fw-bold text-dark">
                                                            <i class="ki-duotone ki-message-text-2 fs-6 text-info me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            Catatan Assignment
                                                        </label>
                                                        <textarea id="assignment_notes" name="notes" class="form-control form-control-solid" rows="3"
                                                            placeholder="Catatan tambahan untuk assignment pembimbing..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            onclick="resetForm()">
                                                            <i class="ki-duotone ki-refresh fs-6 me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            Reset
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="ki-duotone ki-check fs-6 me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            Assign Pembimbing
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- <div class="card border-success">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-user-check me-2"></i>
                                            Assignment Pembimbing (Admin Decision)
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="assignment-form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="pembimbing1" class="form-label fw-bold">Pembimbing
                                                            1:</label>
                                                        <select id="pembimbing1" name="pembimbing1_id" class="form-select"
                                                            data-control="select2" data-hide-search="true" required>
                                                            <option value="">Pilih Pembimbing 1...</option>
                                                        </select>
                                                        <small class="text-muted">Pilih dari rekomendasi AI atau dosen
                                                            lainnya</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="pembimbing2" class="form-label fw-bold">Pembimbing
                                                            2:</label>
                                                        <select id="pembimbing2" name="pembimbing2_id" class="form-select"
                                                            data-control="select2" data-hide-search="true" required>
                                                            <option value="">Pilih Pembimbing 2...</option>
                                                        </select>
                                                        <small class="text-muted">Pilih dari rekomendasi AI atau dosen
                                                            lainnya</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mb-3">
                                                        <label for="assignment_notes" class="form-label">Catatan
                                                            Assignment:</label>
                                                        <textarea id="assignment_notes" name="notes" class="form-control" rows="3"
                                                            placeholder="Catatan tambahan untuk assignment pembimbing..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-success btn-lg">
                                                        <i class="fas fa-save me-2"></i>
                                                        Assign Pembimbing
                                                    </button>
                                                    <button type="button" class="btn btn-secondary btn-lg ms-2"
                                                        onclick="confirmReset()">
                                                        <i class="fas fa-refresh me-2"></i>
                                                        Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!--end::Card-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

@push('jsScript')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        let currentPengajuanId = null;
        let allDosens = [];

        // Notification helper functions
        function showSuccessToast(message, title = 'Berhasil!') {
            toastr.success(message, title);
        }

        function showErrorToast(message, title = 'Error!') {
            toastr.error(message, title);
        }

        function showWarningToast(message, title = 'Perhatian!') {
            toastr.warning(message, title);
        }

        function showInfoToast(message, title = 'Info') {
            toastr.info(message, title);
        }

        $(document).ready(function() {
            loadPengajuanData();
            loadAllDosens();

            // Show welcome message
            showInfoToast('Selamat datang di halaman assignment pembimbing dengan AI!');
        });

        function loadPengajuanData() {
            $.ajax({
                url: '/admin/pengajuan-judul/data',
                method: 'GET',
                success: function(response) {
                    if (response.ok && response.data) {
                        let options = '<option value="">Pilih pengajuan judul...</option>';
                        response.data.forEach(function(pengajuan) {
                            if (pengajuan.status === 'diverifikasi' || pengajuan.status ===
                                'diterima') {
                                options +=
                                    `<option value="${pengajuan.id}">${pengajuan.judul} (${pengajuan.topik}) - ${pengajuan.status}</option>`;
                            }
                        });
                        $('#pengajuan_select').html(options);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading pengajuan data:', xhr);
                    showErrorToast('Gagal memuat data pengajuan judul');
                }
            });
        }

        function loadAllDosens() {
            $.ajax({
                url: '/admin/pembimbing/dosens/available',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        allDosens = response.data;
                    }
                },
                error: function(xhr) {
                    console.error('Error loading dosens:', xhr);
                    showErrorToast('Gagal memuat data dosen');
                }
            });
        }

        function getRecommendations() {
            const pengajuanId = $('#pengajuan_select').val();

            if (!pengajuanId) {
                showWarningToast('Silakan pilih pengajuan judul terlebih dahulu');
                return;
            }

            currentPengajuanId = pengajuanId;
            showLoading();
            hideError();
            hideRecommendation();

            $.ajax({
                url: `/admin/pembimbing/recommendation-naive-bayes/${pengajuanId}`,
                method: 'GET',
                success: function(response) {
                    // console.log(response);
                    hideLoading();
                    if (response.success) {
                        displayRecommendations(response.data);
                        showSuccessToast('Rekomendasi AI berhasil dimuat!');
                    } else {
                        showError(response.message);
                    }
                },
                error: function(xhr) {
                    hideLoading();
                    showError('Terjadi kesalahan saat mengambil rekomendasi');
                    console.error('Error:', xhr);
                }
            });
        }

        function displayRecommendations(data) {
            console.log(data);
            // Display pengajuan info
            const pengajuanInfo = `
        <div class="row">
            <div class="col-md-6">
                <strong>Judul:</strong> ${data.pengajuan.judul}<br>
                <strong>Topik:</strong> ${data.pengajuan.topik}<br>
                <strong>Konsentrasi:</strong> ${data.pengajuan.konsentrasi}
            </div>
            <div class="col-md-6">
                <strong>Status:</strong> <span class="badge badge-${getStatusBadge(data.pengajuan.status)}">${data.pengajuan.status}</span><br>
                <strong>Program Studi:</strong> ${data.pengajuan.id_prodi || '-'}<br>
                <strong>Tanggal Pengajuan:</strong> ${formatDate(data.pengajuan.created_at)}
            </div>
        </div>
    `;
            $('#pengajuan-info').html(pengajuanInfo);

            // Display recommendation cards
            const cardsContainer = $('#recommendation-cards');
            cardsContainer.empty();

            data.recommendations.forEach(function(rec, index) {
                const card = `
            <div class="col-md-4 mb-3">
                <div class="card h-100 ${index < 2 ? 'border-warning' : 'border-secondary'}">
                    <div class="card-header ${index < 2 ? 'bg-warning' : 'bg-secondary'} text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-star me-1"></i>
                            Rekomendasi #${index + 1} 
                            ${index < 2 ? '<span class="badge bg-danger">TOP CHOICE</span>' : ''}
                        </h6>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">${rec.dosen.nama}</h6>
                        <p class="card-text">
                            <small class="text-muted">${rec.dosen.nidn}</small><br>
                            <strong>Score:</strong> <span class="badge badge-primary">${(rec.score * 100).toFixed(2)}%</span>
                        </p>
                        <div class="mt-2">
                            <small class="text-muted">
                                <strong>Keahlian:</strong> ${rec.attributes.keahlian.join(', ') || '-'}<br>
                                <strong>Mata Kuliah:</strong> ${rec.attributes.mata_kuliah.join(', ') || '-'}<br>
                                <strong>History Bimbingan:</strong> ${rec.attributes.history_bimbingan.join(', ') || '-'}<br>
                                <strong>History Penelitian:</strong> ${rec.attributes.history_penelitian.join(', ') || '-'}
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                onclick="selectPembimbing('${rec.dosen.nidn}', '${rec.dosen.nama}')">
                            <i class="fas fa-check me-1"></i>Pilih sebagai Pembimbing
                        </button>
                    </div>
                </div>
            </div>
        `;
                cardsContainer.append(card);
            });

            // Populate pembimbing dropdowns
            populatePembimbingDropdowns(data.recommendations);

            $('#recommendation-section').show();
        }

        function populatePembimbingDropdowns(recommendations) {
            const pembimbing1Select = $('#pembimbing1');
            const pembimbing2Select = $('#pembimbing2');

            // Clear existing options
            pembimbing1Select.empty().append('<option value="">Pilih Pembimbing 1...</option>');
            pembimbing2Select.empty().append('<option value="">Pilih Pembimbing 2...</option>');

            // Add recommended dosens first
            recommendations.forEach(function(rec, index) {
                const option = `<option value="${rec.dosen.nidn}" data-score="${rec.score}">
            ${rec.dosen.nama} (${rec.dosen.nidn}) - Score: ${(rec.score * 100).toFixed(2)}%
        </option>`;

                if (index < 2) {
                    pembimbing1Select.append(option);
                }
                pembimbing2Select.append(option);
            });

            // Add all other dosens
            allDosens.forEach(function(dosen) {
                const isRecommended = recommendations.some(rec => rec.dosen.nidn === dosen.nidn);
                if (!isRecommended) {
                    const option = `<option value="${dosen.nidn}">${dosen.nama} (${dosen.nidn})</option>`;
                    pembimbing1Select.append(option);
                    pembimbing2Select.append(option);
                }
            });
        }

        function selectPembimbing(nidn, nama) {
            // Auto-select for pembimbing 1 if empty, otherwise pembimbing 2
            if (!$('#pembimbing1').val()) {
                $('#pembimbing1').val(nidn).trigger('change');
                showSuccessToast(`Dosen ${nama} dipilih sebagai Pembimbing 1`);
            } else if (!$('#pembimbing2').val()) {
                $('#pembimbing2').val(nidn).trigger('change');
                showSuccessToast(`Dosen ${nama} dipilih sebagai Pembimbing 2`);
            } else {
                showWarningToast('Kedua pembimbing sudah dipilih. Silakan reset jika ingin mengubah.');
            }
        }

        // Form submission
        $('#assignment-form').on('submit', function(e) {
            e.preventDefault();

            const pembimbing1Id = $('#pembimbing1').val();
            const pembimbing2Id = $('#pembimbing2').val();

            if (pembimbing1Id === pembimbing2Id) {
                showErrorToast('Pembimbing 1 dan Pembimbing 2 tidak boleh sama!');
                return;
            }

            if (!currentPengajuanId) {
                showErrorToast('Silakan pilih pengajuan judul terlebih dahulu');
                return;
            }

            // Confirm assignment
            Swal.fire({
                title: 'Konfirmasi Assignment',
                text: 'Apakah Anda yakin ingin menetapkan pembimbing untuk pengajuan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Assign!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitAssignment(pembimbing1Id, pembimbing2Id);
                }
            });
        });

        function submitAssignment(pembimbing1Id, pembimbing2Id) {

            // Show loading with SweetAlert
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang menetapkan pembimbing',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Submit assignment
            $.ajax({
                url: `/admin/pembimbing/assign/${currentPengajuanId}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    pembimbing1_id: pembimbing1Id,
                    pembimbing2_id: pembimbing2Id,
                    notes: $('#assignment_notes').val()
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Pembimbing berhasil ditetapkan!',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            resetForm();
                            loadPengajuanData(); // Refresh pengajuan list
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menetapkan pembimbing: ' + response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menetapkan pembimbing',
                        confirmButtonText: 'OK'
                    });
                    console.error('Error:', xhr);
                }
            });
        }

        function confirmReset() {
            Swal.fire({
                title: 'Konfirmasi Reset',
                text: 'Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    resetForm();
                }
            });
        }

        function resetForm() {
            $('#pembimbing1').val('').trigger('change');
            $('#pembimbing2').val('').trigger('change');
            $('#assignment_notes').val('');
            $('#recommendation-section').hide();
            currentPengajuanId = null;
            showInfoToast('Form telah direset');
        }

        function showLoading() {
            $('#loading-section').show();
        }

        function hideLoading() {
            $('#loading-section').hide();
        }

        function showError(message) {
            $('#error-section').text(message).show();
            // Also show toastr notification
            showErrorToast(message);
        }

        function hideError() {
            $('#error-section').hide();
        }

        function hideRecommendation() {
            $('#recommendation-section').hide();
        }

        function getStatusBadge(status) {
            switch (status) {
                case 'diterima':
                    return 'success';
                case 'diverifikasi':
                    return 'warning';
                case 'ditolak':
                    return 'danger';
                default:
                    return 'secondary';
            }
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            return new Date(dateString).toLocaleDateString('id-ID');
        }
    </script>
@endpush
