@extends('app.layouts.index', ['dashboard' => true])

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Row-->
            <div class="row g-5 g-lg-10 mb-5 mb-lg-10">
                <!--begin::Col-->
                <div>
                    <!--begin::Header-->
                    <div class="bg-gray-900 card-header border-0 p-10 rounded-top">
                        <h1 class="fw-bold text-white">Selamat Datang, {{ Session::get('nama_mhs', 'Pengguna') }}</h1>
                        <p class="fw-bold text-white">Kelola pengajuan judul skripsi/thesis Anda dengan mudah dan efisien
                            melalui dashboard ini.
                        </p>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0">
                        <!--begin::Chart-->
                        <div class="mixed-widget-2-chart card-rounded-bottom bg-gray-900" style="height: 10px"></div>
                        <!--end::Chart-->
                    </div>

                    <!--end::Body-->
                </div>
                <!--end::Col-->
            </div>

            <!--begin::Stats Cards Row-->
            <div class="row g-5 g-lg-10 mb-5 mb-lg-10">
                <!-- Judul Diajukan Card -->
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card card-flush h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Judul
                                    Diajukan</a>
                                <div class="small-circle d-flex align-items-center justify-content-center"
                                    style="background: #e3f2fd; color: #1976d2;">
                                    📝
                                </div>
                            </div>
                            <div class="stat-value mb-2">
                                {{ $totalPengajuan->where('status', 'diajukan')->count() }}
                            </div>
                            <p class="text-gray-600 fs-7 mb-0">
                                Total yang diajukan
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Menunggu Review Card -->
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card card-flush h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Menunggu
                                    Review</a>
                                <div class="small-circle d-flex align-items-center justify-content-center"
                                    style="background: #f3e5f5; color: #7b1fa2;">
                                    ⏳
                                </div>
                            </div>
                            <div class="stat-value mb-2">
                                {{ $totalPengajuan->where('status', 'diverifikasi')->count() }}
                            </div>
                            <p class="text-gray-600 fs-7 mb-0">
                                Sedang ditinjau dosen
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Disetujui Card -->
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card card-flush h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <a href="#"
                                    class="card-title fw-bold text-muted text-hover-primary fs-4">Disetujui</a>
                                <div class="small-circle d-flex align-items-center justify-content-center"
                                    style="background: #e8f5e8; color: #2e7d32;">
                                    ✅
                                </div>
                            </div>
                            <div class="stat-value mb-2">
                                {{ $totalPengajuan->where('status', 'diterima')->count() }}
                            </div>
                            <p class="text-gray-600 fs-7 mb-0">
                                Judul yang diterima
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::Quick Actions Row-->
            <div class="row g-5 g-lg-10 mb-5 mb-lg-10">
                <!-- Ajukan Judul Baru -->
                <div class="col-12 col-md-6 col-lg-4">
                    @if ($totalPengajuan->count() < 3)
                        <a href="{{ route('pengajuan.step1') }}">
                            <div class="card card-flush h-100 hover-elevate-up">
                                <div class="card-body text-center">
                                    <div class="mb-5" style="font-size: 3rem;">➕</div>
                                    <h3 class="fw-bold mb-3">Ajukan Judul Baru</h3>
                                    <p class="text-gray-600 fs-6 mb-0">Kirim proposal judul untuk ditinjau</p>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>

                <!-- Cek Status -->
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="{{ route('pengajuan.index') }}">
                        <div class="card card-flush h-100 hover-elevate-up">
                            <div class="card-body text-center">
                                <div class="mb-5" style="font-size: 3rem;">📋</div>
                                <h3 class="fw-bold mb-3">Cek Status</h3>
                                <p class="text-gray-600 fs-6 mb-0">Lihat perkembangan pengajuan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Panduan -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card card-flush h-100 hover-elevate-up">
                        <div class="card-body text-center">
                            <div class="mb-5" style="font-size: 3rem;">📚</div>
                            <h3 class="fw-bold mb-3">Panduan</h3>
                            <p class="text-gray-600 fs-6 mb-0">Baca panduan pengajuan judul</p>
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::Recent Submissions-->
            <div class="row g-5 g-lg-10 mb-5 mb-lg-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header pt-5">
                            <h3 class="card-title fw-bold text-gray-800">📋 Pengajuan Terbaru</h3>
                        </div>
                        <div class="card-body pt-0">
                            @foreach ($totalPengajuan as $v)
                                <div class="recent-item">
                                    <div class="flex-grow-1">
                                        <div class="recent-title fw-bold text-gray-800 fs-6">{{ $v->judul }}</div>
                                        <div class="recent-desc text-gray-600 fs-7">
                                            {{ Helper::getDateIndo($v->created_at) }}</div>
                                    </div>
                                    <span @class([
                                        'badge fs-8',
                                        'badge-warning' => $v->status == 'diajukan',
                                        'badge-success' => $v->status == 'diterima',
                                        'badge-danger' => $v->status == 'ditolak',
                                    ])>
                                        {{ $v->status }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::Profile Section-->
            <div class="row g-5 g-lg-10">
                <div class="col-12">
                    <div class="card card-flush">
                        <!-- Profile Header -->
                        <div class="bg-light-primary border-0 rounded-top-2 card-header">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start">
                                <div class="flex-grow-1 my-2">
                                    <p class="fs-2 fs-lg-1 text-primary fw-bolder mb-1">
                                        PROFILE MAHASISWA
                                    </p>
                                    <p class="text-primary fw-bold fs-6 mb-0">Program Studi Teknik Informatika</p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Body -->
                        <div class="card-body">
                            <div class="row g-4 g-lg-6">
                                <div class="col-12 col-md-6">
                                    <div class="profile-item">
                                        <div class="profile-label">NIM</div>
                                        <div class="profile-value">{{ Session::get('stb', '') }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="profile-item">
                                        <div class="profile-label">Nama Lengkap</div>
                                        <div class="profile-value">{{ Session::get('nama_mhs', '') }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="profile-item">
                                        <div class="profile-label">Jurusan</div>
                                        <div class="profile-value">{{ Session::get('prodi', '') }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="profile-item">
                                        <div class="profile-label">Email</div>
                                        <div class="profile-value">{{ Session::get('email', '') }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="profile-item">
                                        <div class="profile-label">Alamat</div>
                                        <div class="profile-value">{{ Session::get('alamat', '') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->

    <style>
        .profile-item {
            padding: 1rem 1.5rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #2a5298;
            height: 100%;
        }

        .profile-label {
            font-size: 0.875rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .profile-value {
            font-size: 1rem;
            color: #2c3e50;
            font-weight: 600;
            word-wrap: break-word;
        }

        .small-circle {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            font-size: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .small-circle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #2a5298;
        }

        .recent-item {
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .recent-item:last-child {
            border-bottom: none;
        }

        .recent-desc {
            color: #7f8c8d;
            font-size: 0.875rem;
        }

        .hover-elevate-up {
            transition: all 0.3s ease;
        }

        .hover-elevate-up:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-item {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .recent-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .recent-item .badge {
                align-self: flex-start;
            }
        }

        @media (max-width: 576px) {
            .small-circle {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }
        }
    </style>
@endsection
