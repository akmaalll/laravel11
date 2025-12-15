@extends('admin._layouts.index')

@push('dashboard')
    here
@endpush

@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Sistem Pengajuan Judul</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Dashboard Admin</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            {{-- <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Secondary button-->
                <a href="#" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_export_data">Export Data</a>
                <!--end::Secondary button-->
                <!--begin::Primary button-->
                <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_tambah_pengumuman">Tambah Pengumuman</a>
                <!--end::Primary button-->
            </div> --}}
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row gx-5 gx-xl-10">
                <!--begin::Col-->
                <div class="col-xl-12 mb-10">
                    <!--begin::Statistics Widget-->
                    <div class="card card-flush h-xl-100">
                        <!--begin::Heading-->
                        <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
                            style="background-image:url('public/themes/dist/assets/media/svg/shapes/top-green.png')" data-bs-theme="light">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column text-white pt-15">
                                <span class="fw-bold fs-2x mb-3">Pengajuan Hari Ini</span>
                                <div class="fs-4 text-white">
                                    <span class="opacity-75">Terdapat</span>
                                    <span class="position-relative d-inline-block">
                                        <a href="" class="link-white opacity-75-hover fw-bold d-block mb-1">{{ $diajukan }}
                                            pengajuan</a>
                                        <!--begin::Separator-->
                                        <span
                                            class="position-absolute opacity-50 bottom-0 start-0 border-2 border-body border-bottom w-100"></span>
                                        <!--end::Separator-->
                                    </span>
                                    <span class="opacity-75">menunggu review</span>
                                </div>
                            </h3>
                            <!--end::Title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar pt-5">
                                <!--begin::Menu-->
                                <button
                                    class="btn btn-sm btn-icon btn-active-color-primary btn-color-white bg-white bg-opacity-25 bg-hover-opacity-100 bg-hover-white bg-active-opacity-25 w-20px h-20px"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                    data-kt-menu-overflow="true">
                                    <i class="ki-duotone ki-dots-square fs-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </button>
                                <!--begin::Menu 2-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                                            Quick Actions
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu separator-->
                                    <div class="separator mb-3 opacity-75"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">Review Pengajuan</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">Kelola Dosen</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">Kelola Mahasiswa</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu separator-->
                                    <div class="separator mt-3 opacity-75"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content px-3 py-3">
                                            <a class="btn btn-primary btn-sm px-4" href="#">Generate
                                                Laporan</a>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 2-->
                                <!--end::Menu-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Body-->
                        <div class="card-body mt-n20">
                            <!--begin::Stats-->
                            <div class="mt-n20 position-relative">
                                <!--begin::Row-->
                                <div class="row g-3 g-lg-6">
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-30px me-5 mb-8">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-document fs-1 text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span
                                                    class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $totalPengajuan }}</span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">Total Judul </span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-30px me-5 mb-8">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-check-square fs-1 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span
                                                    class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $diterima }}</span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">Disetujui</span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-30px me-5 mb-8">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-time fs-1 text-warning">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span
                                                    class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $diajukan }}</span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">Diajukan</span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Items-->
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-30px me-5 mb-8">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-cross-square fs-1 text-danger">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Stats-->
                                            <div class="m-0">
                                                <!--begin::Number-->
                                                <span
                                                    class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $ditolak }}</span>
                                                <!--end::Number-->
                                                <!--begin::Desc-->
                                                <span class="text-gray-500 fw-semibold fs-6">Ditolak</span>
                                                <!--end::Desc-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                {{-- <div class="col-xl-8 mb-10">
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-10">
                        <!--begin::Col-->
                        <div class="col-xl-6 mb-xl-10">
                            <!--begin::Recent Submissions Widget-->
                            <div id="kt_pengajuan_terbaru_slider"
                                class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100"
                                data-bs-ride="carousel" data-bs-interval="5000">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <h4 class="card-title d-flex align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">Pengajuan Terbaru</span>
                                        <span class="text-gray-500 mt-1 fw-bold fs-7">12 pengajuan hari ini</span>
                                    </h4>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <!--begin::Carousel Indicators-->
                                        <ol
                                            class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                                            <li data-bs-target="#kt_pengajuan_terbaru_slider" data-bs-slide-to="0"
                                                class="active ms-1"></li>
                                            <li data-bs-target="#kt_pengajuan_terbaru_slider" data-bs-slide-to="1"
                                                class="ms-1"></li>
                                            <li data-bs-target="#kt_pengajuan_terbaru_slider" data-bs-slide-to="2"
                                                class="ms-1"></li>
                                        </ol>
                                        <!--end::Carousel Indicators-->
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body py-6">
                                    <!--begin::Carousel-->
                                    <div class="carousel-inner mt-n5">
                                        <!--begin::Item-->
                                        <div class="carousel-item active show">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex align-items-center mb-5">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label bg-light-primary">
                                                        <span class="text-primary fw-bold fs-4">MH</span>
                                                    </div>
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Info-->
                                                <div class="m-0 flex-grow-1">
                                                    <!--begin::Title-->
                                                    <h5 class="fw-bold text-gray-800 mb-1">Muhammad Haris</h5>
                                                    <!--end::Title-->
                                                    <!--begin::Subtitle-->
                                                    <p class="text-gray-600 fw-semibold mb-2 fs-7">Sistem Informasi
                                                        Manajemen Perpustakaan Berbasis Web</p>
                                                    <!--end::Subtitle-->
                                                    <!--begin::Details-->
                                                    <div class="d-flex gap-3">
                                                        <span class="badge badge-light-warning fs-8">Pending</span>
                                                        <span class="text-gray-500 fs-8">2 jam lalu</span>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Action-->
                                            <div class="m-0">
                                                <a href="#" class="btn btn-sm btn-light me-2 mb-2">Detail</a>
                                                <a href="#" class="btn btn-sm btn-primary mb-2">Review</a>
                                            </div>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Item-->

                                        <!--begin::Item-->
                                        <div class="carousel-item">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex align-items-center mb-5">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label bg-light-success">
                                                        <span class="text-success fw-bold fs-4">SA</span>
                                                    </div>
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Info-->
                                                <div class="m-0 flex-grow-1">
                                                    <!--begin::Title-->
                                                    <h5 class="fw-bold text-gray-800 mb-1">Siti Aminah</h5>
                                                    <!--end::Title-->
                                                    <!--begin::Subtitle-->
                                                    <p class="text-gray-600 fw-semibold mb-2 fs-7">Aplikasi Mobile Learning
                                                        untuk Pembelajaran Bahasa Inggris</p>
                                                    <!--end::Subtitle-->
                                                    <!--begin::Details-->
                                                    <div class="d-flex gap-3">
                                                        <span class="badge badge-light-primary fs-8">Under Review</span>
                                                        <span class="text-gray-500 fs-8">4 jam lalu</span>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Action-->
                                            <div class="m-0">
                                                <a href="#" class="btn btn-sm btn-light me-2 mb-2">Detail</a>
                                                <a href="#" class="btn btn-sm btn-primary mb-2">Review</a>
                                            </div>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Item-->

                                        <!--begin::Item-->
                                        <div class="carousel-item">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex align-items-center mb-5">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label bg-light-info">
                                                        <span class="text-info fw-bold fs-4">RD</span>
                                                    </div>
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Info-->
                                                <div class="m-0 flex-grow-1">
                                                    <!--begin::Title-->
                                                    <h5 class="fw-bold text-gray-800 mb-1">Rizky Dwi</h5>
                                                    <!--end::Title-->
                                                    <!--begin::Subtitle-->
                                                    <p class="text-gray-600 fw-semibold mb-2 fs-7">Analisis Sentimen Media
                                                        Sosial Menggunakan Machine Learning</p>
                                                    <!--end::Subtitle-->
                                                    <!--begin::Details-->
                                                    <div class="d-flex gap-3">
                                                        <span class="badge badge-light-warning fs-8">Pending</span>
                                                        <span class="text-gray-500 fs-8">6 jam lalu</span>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Action-->
                                            <div class="m-0">
                                                <a href="#" class="btn btn-sm btn-light me-2 mb-2">Detail</a>
                                                <a href="#" class="btn btn-sm btn-primary mb-2">Review</a>
                                            </div>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Carousel-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Recent Submissions Widget-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-xl-6 mb-5 mb-xl-10">
                            <!--begin::Dosen Pembimbing Widget-->
                            <div id="kt_dosen_pembimbing_slider"
                                class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100"
                                data-bs-ride="carousel" data-bs-interval="5500">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <h4 class="card-title d-flex align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">Dosen Pembimbing</span>
                                        <span class="text-gray-500 mt-1 fw-bold fs-7">Status bimbingan aktif</span>
                                    </h4>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <!--begin::Carousel Indicators-->
                                        <ol
                                            class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-success">
                                            <li data-bs-target="#kt_dosen_pembimbing_slider" data-bs-slide-to="0"
                                                class="active ms-1"></li>
                                            <li data-bs-target="#kt_dosen_pembimbing_slider" data-bs-slide-to="1"
                                                class="ms-1"></li>
                                            <li data-bs-target="#kt_dosen_pembimbing_slider" data-bs-slide-to="2"
                                                class="ms-1"></li>
                                        </ol>
                                        <!--end::Carousel Indicators-->
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body py-6">
                                    <!--begin::Carousel-->
                                    <div class="carousel-inner">
                                        <!--begin::Item-->
                                        <div class="carousel-item active show">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex align-items-center mb-9">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-70px symbol-circle me-5">
                                                    <span class="symbol-label bg-light-success">
                                                        <i class="ki-duotone ki-profile-user fs-3x text-success">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Info-->
                                                <div class="m-0">
                                                    <!--begin::Name-->
                                                    <h4 class="fw-bold text-gray-800 mb-3">Dr. Ahmad Fauzi, M.Kom</h4>
                                                    <!--end::Name-->
                                                    <!--begin::Stats-->
                                                    <div class="d-flex d-grid gap-5">
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-column flex-shrink-0 me-4">
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-2">
                                                                <i class="ki-duotone ki-user-tick fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>15 Mahasiswa</span>
                                                            <!--end::Section-->
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center text-gray-500 fw-bold fs-7">
                                                                <i
                                                                    class="ki-duotone ki-check-square fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>8 Selesai</span>
                                                            <!--end::Section-->
                                                        </div>
                                                        <!--end::Item-->
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-column flex-shrink-0">
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-2">
                                                                <i class="ki-duotone ki-time fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>7 Progress</span>
                                                            <!--end::Section-->
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center text-gray-500 fw-bold fs-7">
                                                                <i class="ki-duotone ki-star fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>4.8 Rating</span>
                                                            <!--end::Section-->
                                                        </div>
                                                        <!--end::Item-->
                                                    </div>
                                                    <!--end::Stats-->
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Action-->
                                            <div class="m-0">
                                                <a href="#" class="btn btn-sm btn-light me-2 mb-2">Detail</a>
                                                <a href="#" class="btn btn-sm btn-success mb-2">Kelola Bimbingan</a>
                                            </div>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Item-->

                                        <!--begin::Item-->
                                        <div class="carousel-item">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex align-items-center mb-9">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-70px symbol-circle me-5">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="ki-duotone ki-profile-user fs-3x text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Info-->
                                                <div class="m-0">
                                                    <!--begin::Name-->
                                                    <h4 class="fw-bold text-gray-800 mb-3">Dr. Sari Wijaya, M.T</h4>
                                                    <!--end::Name-->
                                                    <!--begin::Stats-->
                                                    <div class="d-flex d-grid gap-5">
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-column flex-shrink-0 me-4">
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-2">
                                                                <i class="ki-duotone ki-user-tick fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>12 Mahasiswa</span>
                                                            <!--end::Section-->
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center text-gray-500 fw-bold fs-7">
                                                                <i
                                                                    class="ki-duotone ki-check-square fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>6 Selesai</span>
                                                            <!--end::Section-->
                                                        </div>
                                                        <!--end::Item-->
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-column flex-shrink-0">
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-2">
                                                                <i class="ki-duotone ki-time fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>6 Progress</span>
                                                            <!--end::Section-->
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center text-gray-500 fw-bold fs-7">
                                                                <i class="ki-duotone ki-star fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>4.7 Rating</span>
                                                            <!--end::Section-->
                                                        </div>
                                                        <!--end::Item-->
                                                    </div>
                                                    <!--end::Stats-->
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Action-->
                                            <div class="m-0">
                                                <a href="#" class="btn btn-sm btn-light me-2 mb-2">Detail</a>
                                                <a href="#" class="btn btn-sm btn-success mb-2">Kelola Bimbingan</a>
                                            </div>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Item-->

                                        <!--begin::Item-->
                                        <div class="carousel-item">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex align-items-center mb-9">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-70px symbol-circle me-5">
                                                    <span class="symbol-label bg-light-warning">
                                                        <i class="ki-duotone ki-profile-user fs-3x text-warning">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Info-->
                                                <div class="m-0">
                                                    <!--begin::Name-->
                                                    <h4 class="fw-bold text-gray-800 mb-3">Prof. Budi Santoso, Ph.D</h4>
                                                    <!--end::Name-->
                                                    <!--begin::Stats-->
                                                    <div class="d-flex d-grid gap-5">
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-column flex-shrink-0 me-4">
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-2">
                                                                <i class="ki-duotone ki-user-tick fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>18 Mahasiswa</span>
                                                            <!--end::Section-->
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center text-gray-500 fw-bold fs-7">
                                                                <i
                                                                    class="ki-duotone ki-check-square fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>12 Selesai</span>
                                                            <!--end::Section-->
                                                        </div>
                                                        <!--end::Item-->
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-column flex-shrink-0">
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-2">
                                                                <i class="ki-duotone ki-time fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>6 Progress</span>
                                                            <!--end::Section-->
                                                            <!--begin::Section-->
                                                            <span
                                                                class="d-flex align-items-center text-gray-500 fw-bold fs-7">
                                                                <i class="ki-duotone ki-star fs-6 text-gray-600 me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>4.9 Rating</span>
                                                            <!--end::Section-->
                                                        </div>
                                                        <!--end::Item-->
                                                    </div>
                                                    <!--end::Stats-->
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Action-->
                                            <div class="m-0">
                                                <a href="#" class="btn btn-sm btn-light me-2 mb-2">Detail</a>
                                                <a href="#" class="btn btn-sm btn-success mb-2">Kelola Bimbingan</a>
                                            </div>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Carousel-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Dosen Pembimbing Widget-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Notification Widget-->
                    <div class="card border-transparent" data-bs-theme="light" style="background-color: #1C325E;">
                        <!--begin::Body-->
                        <div class="card-body d-flex ps-xl-15">
                            <!--begin::Wrapper-->
                            <div class="m-0">
                                <!--begin::Title-->
                                <div class="position-relative fs-2x z-index-2 fw-bold text-white mb-7">
                                    <span class="me-2">Sistem pengajuan judul telah mencatat
                                        <span class="position-relative d-inline-block text-danger">
                                            <a href="#" class="text-danger opacity-75-hover">247 pengajuan</a>
                                            <!--begin::Separator-->
                                            <span
                                                class="position-absolute opacity-50 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                            <!--end::Separator-->
                                        </span></span>
                                    <br />dengan tingkat persetujuan 80.16%
                                </div>
                                <!--end::Title-->
                                <!--begin::Action-->
                                <div class="mb-3">
                                    <a href='#' class="btn btn-danger fw-semibold me-2" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_laporan_bulanan">Laporan Bulanan</a>
                                    <a href="#"
                                        class="btn btn-color-white bg-white bg-opacity-15 bg-hover-opacity-25 fw-semibold">Panduan
                                        Admin</a>
                                </div>
                                <!--begin::Action-->
                            </div>
                            <!--begin::Wrapper-->
                            <!--begin::Illustration-->
                            <img src="assets/media/illustrations/sigma-1/17-dark.png"
                                class="position-absolute me-3 bottom-0 end-0 h-200px" alt="" />
                            <!--end::Illustration-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Notification Widget-->
                </div> --}}
                <!--end::Col-->
            </div>
            <!--end::Row-->

            <!--begin::Recent Activities-->
            {{-- <div class="row gx-5 gx-xl-10 mb-5 mb-xl-10">
                <!--begin::Col-->
                <div class="col-xl-12">
                    <!--begin::Table Widget 5-->
                    <div class="card card-flush h-xl-100">
                        <!--begin::Header-->
                        <div class="card-header pt-7">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">Aktivitas Terbaru</span>
                                <span class="text-gray-500 pt-2 fw-semibold fs-6">Aktivitas sistem dalam 24 jam
                                    terakhir</span>
                            </h3>
                            <!--end::Title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-sm btn-light">Lihat Semua</a>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table class="table table-row-dashed align-middle gs-5">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-200px">Mahasiswa</th>
                                            <th class="min-w-150px">Judul</th>
                                            <th class="min-w-100px">Status</th>
                                            <th class="min-w-100px">Dosen Pembimbing</th>
                                            <th class="min-w-100px">Waktu</th>
                                            <th class="text-end min-w-100px pe-4">Aksi</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50px me-3">
                                                        <div class="symbol-label bg-light-primary">
                                                            <span class="text-primary fw-bold">MH</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="#"
                                                            class="text-gray-800 text-hover-primary mb-1 fs-6 fw-bold">Muhammad
                                                            Haris</a>
                                                        <span class="text-muted fw-semibold">21.01.4567</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block mb-1 fs-7">Sistem Informasi
                                                    Manajemen...</span>
                                                <span class="text-muted fw-semibold d-block fs-8">Teknik Informatika</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-warning fs-7 fw-bold">Pending Review</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-7">Dr. Ahmad Fauzi</span>
                                            </td>
                                            <td>
                                                <span class="text-muted fw-semibold">2 jam lalu</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="#"
                                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                    <i class="ki-duotone ki-black-right fs-2 text-gray-500"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50px me-3">
                                                        <div class="symbol-label bg-light-success">
                                                            <span class="text-success fw-bold">SA</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="#"
                                                            class="text-gray-800 text-hover-primary mb-1 fs-6 fw-bold">Siti
                                                            Aminah</a>
                                                        <span class="text-muted fw-semibold">21.01.4568</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block mb-1 fs-7">Aplikasi Mobile
                                                    Learning...</span>
                                                <span class="text-muted fw-semibold d-block fs-8">Sistem Informasi</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-success fs-7 fw-bold">Disetujui</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-7">Dr. Sari Wijaya</span>
                                            </td>
                                            <td>
                                                <span class="text-muted fw-semibold">4 jam lalu</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="#"
                                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                    <i class="ki-duotone ki-black-right fs-2 text-gray-500"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50px me-3">
                                                        <div class="symbol-label bg-light-info">
                                                            <span class="text-info fw-bold">RD</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="#"
                                                            class="text-gray-800 text-hover-primary mb-1 fs-6 fw-bold">Rizky
                                                            Dwi</a>
                                                        <span class="text-muted fw-semibold">21.01.4569</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block mb-1 fs-7">Analisis Sentimen
                                                    Media Sosial...</span>
                                                <span class="text-muted fw-semibold d-block fs-8">Teknik Informatika</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-primary fs-7 fw-bold">Under Review</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-7">Prof. Budi Santoso</span>
                                            </td>
                                            <td>
                                                <span class="text-muted fw-semibold">6 jam lalu</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="#"
                                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                    <i class="ki-duotone ki-black-right fs-2 text-gray-500"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50px me-3">
                                                        <div class="symbol-label bg-light-danger">
                                                            <span class="text-danger fw-bold">AN</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="#"
                                                            class="text-gray-800 text-hover-primary mb-1 fs-6 fw-bold">Andi
                                                            Nugraha</a>
                                                        <span class="text-muted fw-semibold">21.01.4570</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block mb-1 fs-7">E-Commerce
                                                    Platform...</span>
                                                <span class="text-muted fw-semibold d-block fs-8">Sistem Informasi</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-danger fs-7 fw-bold">Perlu Revisi</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-800 fw-bold d-block fs-7">Dr. Ahmad Fauzi</span>
                                            </td>
                                            <td>
                                                <span class="text-muted fw-semibold">8 jam lalu</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="#"
                                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                    <i class="ki-duotone ki-black-right fs-2 text-gray-500"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Table Widget 5-->
                </div>
                <!--end::Col-->
            </div> --}}
            <!--end::Recent Activities-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
