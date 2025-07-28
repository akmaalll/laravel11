@extends('admin._layouts.index')

{{-- @push('cssScript')
    @include('admin._layouts.partial._css')
@endpush --}}

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
            Data
        @endslot
    @endcomponent
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Products-->
            <div class="card card-flush">

                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <div class="mw-100px me-3">
                            <select class="form-select form-select-solid me-3" data-control="select2" data-hide-search="true"
                                data-placeholder="Per Page" id="perPage">
                                <option>5</option>
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>
                        <div class="d-flex">
                            <input id="input_search" type="text" class="form-control form-control-solid w-250px me-3"
                                placeholder="Search">

                            <button id="button_search" class="btn btn-secondary me-3">
                                <span class="btn-label">
                                    <i class="fa fa-search"></i>
                                </span>
                            </button>

                            <button id="button_refresh" class="btn btn-secondary">
                                <span class="btn-label">
                                    <i class="fa fa-sync"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    <!--end::Card title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="{{ route($title . '.create') }}" class="btn btn-success">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Add New
                        </a>
                    </div>
                    <!--end::Card toolbar-->
                </div>

                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                            <thead>
                                <tr class="text-start text-gray-600 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-20px pe-2"> No </th>
                                    <th class="min-w-200px"> Mahasiswa </th>
                                    <th class="min-w-200px"> Judul </th>
                                    <th class="min-w-200px"> Topik </th>
                                    <th class="min-w-200px"> Status </th>
                                    <th class="text-end min-w-70px"> Actions </th>
                                </tr>
                            </thead>

                            <tbody class="fw-semibold text-gray-600 datatables">
                            </tbody>

                        </table>
                    </div>
                    <!--end::Table-->

                    <!--begin::Pagination-->
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex flex-wrap py-2 mr-3">
                            <div class="text-center pagination">
                                <div id="contentPage"></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center py-3">
                            <ul class="pagination twbs-pagination">
                            </ul>
                        </div>
                    </div>
                    <!--end::Pagination-->

                </div>



                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!-- Modal Pembimbing Assignment -->
    <div class="modal fade" id="pembimbingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title">
                        <i class="ki-duotone ki-user-tick fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Assignment Pembimbing dengan AI
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Loading Section -->
                    <div id="loading-section" style="display: none;" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Menganalisis dan memberikan rekomendasi AI...</p>
                    </div>

                    <!-- Error Section -->
                    <div id="error-section" style="display: none;" class="alert alert-danger">
                        <i class="ki-duotone ki-cross-circle fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span id="error-message"></span>
                    </div>

                    <!-- Content Section -->
                    <div id="content-section" style="display: none;">
                        <!-- Pengajuan Info Card -->
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

                        <!-- AI Recommendations Card -->
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

                        <!-- Assignment Form Card -->
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
                                                <label for="assignment_notes" class="form-label fw-bold text-dark">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('jsScript')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
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
        // Global variables for modal
        let currentPengajuanId = null;
        let allDosens = [];

        // Load all dosens on page load
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
                }
            });
        }

        // Show pembimbing modal
        function showPembimbingModal(pengajuanId, judul, topik) {
            console.log('showPembimbingModal called with:', pengajuanId, judul, topik);
            currentPengajuanId = pengajuanId;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('pembimbingModal'));
            modal.show();

            // Show loading
            showLoading();
            hideError();
            hideContent();

            // Load recommendations
            $.ajax({
                url: `/admin/pembimbing/recommendation-naive-bayes/${pengajuanId}`,
                method: 'GET',
                success: function(response) {
                    hideLoading();
                    if (response.success) {
                        displayContent(response.data);
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

        // Display content in modal
        function displayContent(data) {
            // Display pengajuan info
            const pengajuanInfo = `
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <span class="text-muted fs-7">Judul</span>
                        <span class="fw-bold text-dark">${data.pengajuan.judul}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <span class="text-muted fs-7">Topik</span>
                        <span class="fw-bold text-dark">${data.pengajuan.topik}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <span class="text-muted fs-7">Konsentrasi</span>
                        <span class="fw-bold text-dark">${data.pengajuan.konsentrasi || '-'}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <span class="text-muted fs-7">Program Studi</span>
                        <span class="fw-bold text-dark">${data.pengajuan.prodi ? data.pengajuan.prodi.nama : '-'}</span>
                    </div>
                </div>
            `;
            $('#pengajuan-info').html(pengajuanInfo);

            // Display recommendation cards
            const cardsContainer = $('#recommendation-cards');
            cardsContainer.empty();

            data.recommendations.forEach(function(rec, index) {
                const card = `
                    <div class="col-md-4 mb-4">
                        <div class="card card-custom h-100 ${index < 2 ? 'border border-warning' : 'border border-secondary'}">
                            <div class="card-header ${index < 2 ? 'bg-light-warning' : 'bg-light-secondary'}">
                                <div class="card-title">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-star fs-2 ${index < 2 ? 'text-warning' : 'text-secondary'} me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <div>
                                            <h6 class="mb-0">Rekomendasi #${index + 1}</h6>
                                            ${index < 2 ? '<small class="text-warning fw-bold">TOP CHOICE</small>' : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title text-dark fw-bold">${rec.dosen.nama}</h6>
                                <p class="text-muted fs-7 mb-2">${rec.dosen.nidn}</p>
                                <div class="mb-3">
                                    <span class="badge badge-primary fs-7">
                                        Score: ${(rec.score * 100).toFixed(2)}%
                                    </span>
                                </div>
                                <div class="border-top pt-3">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <small class="text-muted">
                                                <strong>Keahlian:</strong><br>
                                                ${rec.attributes.keahlian && rec.attributes.keahlian.length > 0 ? rec.attributes.keahlian.join(', ') : '-'}
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <small class="text-muted">
                                                <strong>Mata Kuliah:</strong><br>
                                                ${rec.attributes.mata_kuliah && rec.attributes.mata_kuliah.length > 0 ? rec.attributes.mata_kuliah.join(', ') : '-'}
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <small class="text-muted">
                                                <strong>History Bimbingan:</strong><br>
                                                ${rec.attributes.history_bimbingan && rec.attributes.history_bimbingan.length > 0 ? rec.attributes.history_bimbingan.join(', ') : '-'}
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <small class="text-muted">
                                                <strong>History Penelitian:</strong><br>
                                                ${rec.attributes.history_penelitian && rec.attributes.history_penelitian.length > 0 ? rec.attributes.history_penelitian.join(', ') : '-'}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-sm btn-outline-primary w-100" 
                                        onclick="selectPembimbing('${rec.dosen.nidn}', '${rec.dosen.nama}')">
                                    <i class="ki-duotone ki-check fs-6 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Pilih sebagai Pembimbing
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                cardsContainer.append(card);
            });

            // Populate pembimbing dropdowns
            populatePembimbingDropdowns(data.recommendations);

            $('#content-section').show();
        }

        // Populate pembimbing dropdowns
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

        // Select pembimbing
        function selectPembimbing(nidn, nama) {
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

        // Reset form
        function resetForm() {
            $('#pembimbing1').val('').trigger('change');
            $('#pembimbing2').val('').trigger('change');
            $('#assignment_notes').val('');
            $('#content-section').hide();
            currentPengajuanId = null;
            showInfoToast('Form telah direset');
        }

        // Show loading
        function showLoading() {
            $('#loading-section').show();
        }

        // Hide loading
        function hideLoading() {
            $('#loading-section').hide();
        }

        // Show error
        function showError(message) {
            $('#error-message').text(message);
            $('#error-section').show();
            // Also show toastr notification
            showErrorToast(message);
        }

        // Hide error
        function hideError() {
            $('#error-section').hide();
        }

        // Hide content
        function hideContent() {
            $('#content-section').hide();
        }

        // Form submission
        $(document).on('submit', '#assignment-form', function(e) {
            e.preventDefault();

            const pembimbing1Id = $('#pembimbing1').val();
            const pembimbing2Id = $('#pembimbing2').val();

            if (pembimbing1Id === pembimbing2Id) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Pembimbing 1 dan Pembimbing 2 tidak boleh sama!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!currentPengajuanId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Silakan pilih pengajuan judul terlebih dahulu',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Show loading
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
                            $('#pembimbingModal').modal('hide');
                            // Refresh the page to show updated data
                            location.reload();
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
        });

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

        // Load all dosens on document ready
        $(document).ready(function() {
            loadAllDosens();

            // Show welcome message
            showInfoToast('Selamat datang di sistem assignment pembimbing dengan AI!');
        });
        $(document).ready(function() {
            loadpage(5, '');
            var $pagination = $('.twbs-pagination');
            var defaultOpts = {
                totalPages: 1,
                prev: '&#8672;',
                next: '&#8674;',
                first: '&#8676;',
                last: '&#8677;',
            };
            $pagination.twbsPagination(defaultOpts);

            function loaddata(page, per_page, search) {
                $.ajax({
                    url: '{{ route($title . '.data') }}',
                    data: {
                        "page": page,
                        "per_page": per_page,
                        "search": search,
                    },
                    type: "GET",
                    datatype: "json",
                    success: function(data) {
                        $(".datatables").html(data.html);
                    }
                });
            }

            function loadDosen() {
                $.ajax({
                    url: '{{ route('admin.pengajuan-judul.dosen') }}',
                    type: "GET",
                    datatype: "json",
                    success: function(data) {
                        window.dosenData = data;
                    }
                });
            }

            loadDosen();

            function loadpage(per_page, search) {
                $.ajax({
                    url: '{{ route($title . '.data') }}',
                    data: {
                        "per_page": per_page,
                        "search": search,
                    },
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if ($pagination.data("twbs-pagination")) {
                            $pagination.twbsPagination('destroy');
                            $(".datatables").html('<tr><td colspan="4">Data not found</td></tr>');
                        }
                        $pagination.twbsPagination($.extend({}, defaultOpts, {
                            startPage: 1,
                            totalPages: response.total_page,
                            visiblePages: 8,
                            prev: '&#8672;',
                            next: '&#8674;',
                            first: '&#8676;',
                            last: '&#8677;',
                            onPageClick: function(event, page) {
                                if (page == 1) {
                                    var to = 1;
                                } else {
                                    var to = page * per_page - (per_page - 1);
                                }
                                if (page == response.total_page) {
                                    var end = response.total_data;
                                } else {
                                    var end = page * per_page;
                                }
                                $('#contentPage').text('Showing ' + to + ' to ' + end +
                                    ' of ' +
                                    response.total_data + ' entries');
                                loaddata(page, per_page, search);
                            }
                        }));
                    }
                });
            }

            $("#button_search, #perPage").on('click change', function(event) {
                let search = $('#input_search').val();
                let per_page = $('#perPage').val() ?? 5;
                loadpage(per_page, search);
            });

            $("#button_refresh").on('click', function(event) {
                $('#input_search').val('');
                loadpage(5, '');
            });


            // proses delete data
            $('body').on('click', '.deleteData', function() {
                var id = $(this).data("id");
                Swal.fire({
                    title: "Are you sure to Delete?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: '{{ url("admin/$title") }}/' + id,
                            success: function(data) {
                                loadpage(5, '');
                                toastr.success("Successful delete data!");
                            },
                            error: function(data) {
                                toastr.error("Failed delete data!");
                            }
                        });
                    }
                });
            });


        });
    </script>
@endpush
