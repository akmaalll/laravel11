@extends('admin._layouts.index')

@push('pembimbing')
    active
@endpush

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <select class="form-select" data-placeholder="Pilih Judul" data-control="select2"
                                    data-hide-search="false" id="pengajuan_select">
                                    <option value="">-- Pilih Pengajuan --</option>
                                    @foreach (Helper::getDataJudul('mst_judul') as $pengajuan)
                                        <option value="{{ $pengajuan->id }}">
                                            {{ $pengajuan->judul }} - {{ $pengajuan->status }}
                                            - {{ $pengajuan->nama_keahlian }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="button" class="btn btn-primary btn-lg" id="btn-get-recommendation">
                                        <i class="fas fa-magic me-2"></i>
                                        Dapatkan Rekomendasi
                                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pengajuan -->
                    <div id="detail-pengajuan" class="d-none">
                        <div class="alert alert-light-info border-dashed border-info">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Detail Pengajuan
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Judul:</strong> <span id="detail-judul"></span></p>
                                    <p><strong>Status:</strong> <span id="detail-status" class="badge"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Bidang Keahlian:</strong> <span id="detail-keahlian"></span></p>
                                    <p><strong>Tanggal Pengajuan:</strong> <span id="detail-tanggal"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Rekomendasi -->
                    <div id="hasil-rekomendasi" class="d-none">
                        <div class="separator separator-dashed my-6"></div>

                        <h4 class="mb-4">
                            <i class="fas fa-chart-line text-success me-2"></i>
                            Hasil Rekomendasi Naive Bayes
                        </h4>

                        <!-- Legend -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light-primary">
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6 class="fw-bold mb-3">Keterangan Fitur:</h6>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="bullet bullet-dot bg-success me-2"></span>
                                                            <span><strong>Keahlian:</strong> Sesuai bidang keahlian</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="bullet bullet-dot bg-warning me-2"></span>
                                                            <span><strong>Penelitian:</strong> Pengalaman penelitian
                                                                serupa</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="bullet bullet-dot bg-info me-2"></span>
                                                            <span><strong>Judul:</strong> Pengalaman bimbingan serupa</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h6 class="fw-bold mb-3">Aturan Pembimbingan:</h6>
                                                <div class="text-sm">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="fas fa-user-tie text-success me-2"></i>
                                                        <span><strong>Lektor:</strong> Bisa Pembimbing 1 & 2</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="fas fa-user-graduate text-warning me-2"></i>
                                                        <span><strong>Ahli:</strong> Hanya Pembimbing 2</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Rekomendasi -->
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 gy-5" id="tabel-rekomendasi">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800">
                                        <th class="text-center">Rank</th>
                                        <th>NIDN</th>
                                        <th>Nama Dosen</th>
                                        <th class="text-center">Jabatan Fungsional</th>
                                        <th class="text-center">Fitur</th>
                                        <th class="text-center">Probabilitas</th>
                                        <th class="text-center">Prediksi</th>
                                        <th class="text-center">Skor Kelayakan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-rekomendasi">
                                    <!-- Data akan diisi via JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Form Assignment -->
                        <div class="separator separator-dashed my-6"></div>

                        <div class="card bg-light-success">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-user-plus text-success me-2"></i>
                                    Assignment Pembimbing
                                </h5>
                                <form id="form-assignment">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label class="form-label fw-bold">Pembimbing 1:</label>
                                            <select class="form-select" data-control="select2" id="pembimbing1"
                                                name="pembimbing1" required>
                                                <option value="">-- Pilih Pembimbing 1 --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label fw-bold">Pembimbing 2:</label>
                                            <select class="form-select" data-control="select2" id="pembimbing2"
                                                name="pembimbing2" required>
                                                <option value="">-- Pilih Pembimbing 2 --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-save me-1"></i>
                                                Assign
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
        $(document).ready(function() {
            // Konfigurasi Toastr
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toastr-top-right",
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

            // Event handler untuk tombol Get Recommendation
            $('#btn-get-recommendation').on('click', function() {
                const selectedId = $('#pengajuan_select').val();

                if (!selectedId) {
                    toastr.error('Silakan pilih pengajuan terlebih dahulu!');
                    return;
                }

                getRecommendation(selectedId);
            });

            // Fungsi untuk mendapatkan rekomendasi
            function getRecommendation(pengajuanId) {
                const btn = $('#btn-get-recommendation');
                const spinner = btn.find('.spinner-border');

                // Show loading
                btn.prop('disabled', true);
                spinner.removeClass('d-none');

                // Clear previous results
                $('#detail-pengajuan, #hasil-rekomendasi').addClass('d-none');

                $.ajax({
                    url: `/admin/judul-pengajuan/${pengajuanId}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response); // Debug

                        if (response.dataPengajuan && response.rekomendasi) {
                            displayPengajuanDetail(response.dataPengajuan);
                            displayRekomendasi(response.rekomendasi);
                            populatePembimbingOptions(response.rekomendasi);

                            $('#detail-pengajuan, #hasil-rekomendasi').removeClass('d-none');

                            toastr.success('Rekomendasi berhasil didapatkan!');
                        } else {
                            toastr.error('Format response tidak sesuai!');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        toastr.error('Terjadi kesalahan saat mengambil rekomendasi!');
                    },
                    complete: function() {
                        // Hide loading
                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            }

            // Fungsi untuk menampilkan detail pengajuan
            function displayPengajuanDetail(data) {
                console.log(data)
                $('#detail-judul').text(data.judul || '-');

                const statusBadge = $('#detail-status');
                statusBadge.text(data.status || '-');

                // Set badge color based on status
                statusBadge.removeClass('badge-success badge-warning badge-danger badge-info');
                switch (data.status) {
                    case 'diterima':
                        statusBadge.addClass('badge-success');
                        break;
                    case 'pending':
                        statusBadge.addClass('badge-warning');
                        break;
                    case 'ditolak':
                        statusBadge.addClass('badge-danger');
                        break;
                    default:
                        statusBadge.addClass('badge-info');
                }

                $('#detail-keahlian').text(data.nama_keahlian || data.id_keahlian || '-');
                $('#detail-tanggal').text(formatDate(data.created_at) || '-');
            }

            // Fungsi untuk menampilkan rekomendasi
            function displayRekomendasi(rekomendasi) {
                const tbody = $('#tbody-rekomendasi');
                tbody.empty();

                if (!rekomendasi || rekomendasi.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                Tidak ada rekomendasi dosen yang ditemukan
                            </td>
                        </tr>
                    `);
                    return;
                }

                rekomendasi.forEach((item, index) => {
                    const rank = index + 1;
                    const fitur = item.fitur || {};
                    const probs = item.probs || {};
                    const jabatan = item.jabatan_fungsional || '-';

                    // Feature icons
                    const keahlianIcon = fitur.keahlian ?
                        '<i class="fas fa-check-circle text-success" title="Sesuai Keahlian"></i>' :
                        '<i class="fas fa-times-circle text-danger" title="Tidak Sesuai Keahlian"></i>';

                    const penelitianIcon = fitur.penelitian ?
                        '<i class="fas fa-check-circle text-success" title="Ada Penelitian"></i>' :
                        '<i class="fas fa-times-circle text-danger" title="Tidak Ada Penelitian"></i>';

                    const judulIcon = fitur.judul ?
                        '<i class="fas fa-check-circle text-success" title="Ada Pengalaman Bimbingan"></i>' :
                        '<i class="fas fa-times-circle text-danger" title="Tidak Ada Pengalaman"></i>';

                    // Jabatan badge dan aturan pembimbingan
                    let jabatanBadge = '';
                    let pembimbingRule = '';
                    let canBePembimbing1 = false;
                    let canBePembimbing2 = false;

                    const jabatanLower = jabatan.toLowerCase();
                    if (jabatanLower.includes('lektor')) {
                        jabatanBadge = '<span class="badge badge-success">Lektor</span>';
                        pembimbingRule = 'Pembimbing 1 & 2';
                        canBePembimbing1 = true;
                        canBePembimbing2 = true;
                    } else if (jabatanLower.includes('ahli')) {
                        jabatanBadge = '<span class="badge badge-warning">Ahli</span>';
                        pembimbingRule = 'Hanya Pembimbing 2';
                        canBePembimbing1 = false;
                        canBePembimbing2 = true;
                    } else {
                        jabatanBadge = `<span class="badge badge-secondary">${jabatan}</span>`;
                        pembimbingRule = 'Tidak Memenuhi Syarat';
                        canBePembimbing1 = false;
                        canBePembimbing2 = false;
                    }

                    // Prediksi badge
                    const prediksiClass = item.prediksi === 'Layak' ? 'badge-success' : 'badge-danger';

                    // Progress bar untuk skor
                    const skorPersen = Math.round((item.skor || 0) * 100);
                    const progressClass = skorPersen >= 70 ? 'bg-success' : skorPersen >= 50 ?
                        'bg-warning' : 'bg-danger';

                    // Rank badge
                    let rankClass = 'badge-secondary';
                    if (rank === 1) rankClass = 'badge-success';
                    else if (rank === 2) rankClass = 'badge-warning';
                    else if (rank === 3) rankClass = 'badge-info';

                    // Action buttons
                    let actionButtons = '';
                    const isEligible = item.prediksi === 'Layak' && (canBePembimbing1 || canBePembimbing2);

                    if (isEligible) {
                        if (canBePembimbing1 && canBePembimbing2) {
                            actionButtons = `
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary btn-select-pembimbing1" 
                                            data-nidn="${item.nidn}" 
                                            data-nama="${item.nama}"
                                            data-jabatan="${jabatan}">
                                        <i class="fas fa-user"></i> P1
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary btn-select-pembimbing2" 
                                            data-nidn="${item.nidn}" 
                                            data-nama="${item.nama}"
                                            data-jabatan="${jabatan}">
                                        <i class="fas fa-user-plus"></i> P2
                                    </button>
                                </div>
                            `;
                        } else if (canBePembimbing2) {
                            actionButtons = `
                                <button class="btn btn-sm btn-outline-secondary btn-select-pembimbing2" 
                                        data-nidn="${item.nidn}" 
                                        data-nama="${item.nama}"
                                        data-jabatan="${jabatan}">
                                    <i class="fas fa-user-plus"></i> P2
                                </button>
                            `;
                        }
                    } else {
                        actionButtons = `
                            <span class="text-muted">
                                <i class="fas fa-ban"></i> Tidak Memenuhi Syarat
                            </span>
                        `;
                    }

                    tbody.append(`
                        <tr>
                            <td class="text-center">
                                <span class="badge ${rankClass} fs-6">#${rank}</span>
                            </td>
                            <td class="fw-bold">${item.nidn || '-'}</td>
                            <td>${item.nama || '-'}</td>
                            <td class="text-center">
                                <div>${jabatanBadge}</div>
                                <small class="text-muted">${pembimbingRule}</small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    ${keahlianIcon}
                                    ${penelitianIcon}
                                    ${judulIcon}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="text-sm">
                                    <div class="text-success">Layak: ${Math.round((probs.Layak || 0) * 100)}%</div>
                                    <div class="text-danger">Tidak: ${Math.round((probs['Tidak Layak'] || 0) * 100)}%</div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge ${prediksiClass}">${item.prediksi || '-'}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="progress progress-sm w-75 mb-1" style="height: 8px;">
                                        <div class="progress-bar ${progressClass}" 
                                             style="width: ${skorPersen}%"></div>
                                    </div>
                                    <span class="text-muted fs-8">${item.skor || 0}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                ${actionButtons}
                            </td>
                        </tr>
                    `);
                });
            }

            // Fungsi untuk populate options pembimbing
            function populatePembimbingOptions(rekomendasi) {
                const select1 = $('#pembimbing1');
                const select2 = $('#pembimbing2');

                select1.find('option:not(:first)').remove();
                select2.find('option:not(:first)').remove();

                // Filter berdasarkan kelayakan dan jabatan
                rekomendasi.forEach(item => {
                    if (item.prediksi === 'Layak') {
                        const jabatan = (item.jabatan_fungsional || '').toLowerCase();
                        const optionText =
                            `${item.nama} (${item.nidn}) - ${item.jabatan_fungsional} - Skor: ${item.skor}`;

                        // Lektor bisa jadi pembimbing 1 dan 2
                        if (jabatan.includes('lektor')) {
                            const option =
                                `<option value="${item.nidn}" data-jabatan="${item.jabatan_fungsional}">${optionText}</option>`;
                            select1.append(option);
                            select2.append(option);
                        }
                        // Ahli hanya bisa jadi pembimbing 2
                        else if (jabatan.includes('ahli')) {
                            const option =
                                `<option value="${item.nidn}" data-jabatan="${item.jabatan_fungsional}">${optionText}</option>`;
                            select2.append(option);
                        }
                    }
                });
            }

            // Event handler untuk tombol pilih pembimbing 1
            $(document).on('click', '.btn-select-pembimbing1', function() {
                const nidn = $(this).data('nidn');
                const nama = $(this).data('nama');
                const jabatan = $(this).data('jabatan');

                // Check if already selected
                const select1Val = $('#pembimbing1').val();
                const select2Val = $('#pembimbing2').val();

                if (select1Val === nidn || select2Val === nidn) {
                    toastr.warning('Dosen ini sudah dipilih sebagai pembimbing!');
                    return;
                }

                // Check jabatan eligibility
                const jabatanLower = jabatan.toLowerCase();
                if (!jabatanLower.includes('lektor')) {
                    toastr.error('Hanya dosen dengan jabatan Lektor yang bisa menjadi Pembimbing 1!');
                    return;
                }

                $('#pembimbing1').val(nidn).trigger('change');
                toastr.success(`${nama} (${jabatan}) ditambahkan sebagai Pembimbing 1`);
            });

            // Event handler untuk tombol pilih pembimbing 2
            $(document).on('click', '.btn-select-pembimbing2', function() {
                const nidn = $(this).data('nidn');
                const nama = $(this).data('nama');
                const jabatan = $(this).data('jabatan');

                // Check if already selected
                const select1Val = $('#pembimbing1').val();
                const select2Val = $('#pembimbing2').val();

                if (select1Val === nidn || select2Val === nidn) {
                    toastr.warning('Dosen ini sudah dipilih sebagai pembimbing!');
                    return;
                }

                // Check jabatan eligibility
                const jabatanLower = jabatan.toLowerCase();
                if (!jabatanLower.includes('lektor') && !jabatanLower.includes('ahli')) {
                    toastr.error(
                        'Hanya dosen dengan jabatan Lektor atau Ahli yang bisa menjadi Pembimbing 2!');
                    return;
                }

                $('#pembimbing2').val(nidn).trigger('change');
                toastr.success(`${nama} (${jabatan}) ditambahkan sebagai Pembimbing 2`);
            });

            // Prevent selecting same dosen and validate jabatan rules
            $('#pembimbing1').on('change', function() {
                const thisVal = $(this).val();
                const otherVal = $('#pembimbing2').val();

                if (thisVal && thisVal === otherVal) {
                    toastr.error('Pembimbing 1 dan Pembimbing 2 tidak boleh sama!');
                    $(this).val('').trigger('change');
                    return;
                }

                // Validate jabatan for pembimbing 1
                if (thisVal) {
                    const selectedOption = $(this).find('option:selected');
                    const jabatan = selectedOption.data('jabatan') || '';
                    const jabatanLower = jabatan.toLowerCase();

                    if (!jabatanLower.includes('lektor')) {
                        toastr.error('Pembimbing 1 harus memiliki jabatan Lektor!');
                        $(this).val('').trigger('change');
                    }
                }
            });

            $('#pembimbing2').on('change', function() {
                const thisVal = $(this).val();
                const otherVal = $('#pembimbing1').val();

                if (thisVal && thisVal === otherVal) {
                    toastr.error('Pembimbing 1 dan Pembimbing 2 tidak boleh sama!');
                    $(this).val('').trigger('change');
                    return;
                }

                // Validate jabatan for pembimbing 2
                if (thisVal) {
                    const selectedOption = $(this).find('option:selected');
                    const jabatan = selectedOption.data('jabatan') || '';
                    const jabatanLower = jabatan.toLowerCase();

                    if (!jabatanLower.includes('lektor') && !jabatanLower.includes('ahli')) {
                        toastr.error('Pembimbing 2 harus memiliki jabatan Lektor atau Ahli!');
                        $(this).val('').trigger('change');
                    }
                }
            });

            // Form assignment submission
            $('#form-assignment').on('submit', function(e) {
                e.preventDefault();

                const pembimbing1 = $('#pembimbing1').val();
                const pembimbing2 = $('#pembimbing2').val();
                const pengajuanId = $('#pengajuan_select').val();

                if (!pembimbing1 || !pembimbing2) {
                    toastr.error('Kedua pembimbing harus dipilih!');
                    return;
                }

                if (!pengajuanId) {
                    toastr.error('Pengajuan harus dipilih!');
                    return;
                }

                // Show loading
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

                // AJAX call to save assignment
                $.ajax({
                    url: '/admin/save-assignment',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        pengajuan_id: pengajuanId,
                        pembimbing1: pembimbing1,
                        pembimbing2: pembimbing2
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);

                            // Reset form
                            $('#form-assignment')[0].reset();
                            $('#pembimbing1, #pembimbing2').val('').trigger('change');

                            // Optional: Hide results or refresh
                            // $('#hasil-rekomendasi').addClass('d-none');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseJSON);
                        const errorMessage = xhr.responseJSON?.message ||
                            'Terjadi kesalahan saat menyimpan assignment!';
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        // Reset button
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Helper function to format date
            function formatDate(dateString) {
                if (!dateString) return '-';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
        });
    </script>

    <style>
        .progress-sm {
            height: 8px;
        }

        .bullet-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .table th {
            border-top: none;
            background-color: #f8f9fa;
        }

        .card-title {
            margin-bottom: 0;
        }

        .separator-dashed {
            border-top: 1px dashed #dee2e6 !important;
        }

        .fs-8 {
            font-size: 0.75rem;
        }
    </style>
@endpush
