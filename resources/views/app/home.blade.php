@extends('app.layouts.index', ['dashboard' => true])

@section('content')
<!--begin::Toolbar-->
<div class="toolbar py-3 py-lg-6" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
            <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">Dashboard
                <!--begin::Separator-->
                <span class="h-20px border-gray-500 border-start mx-3"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-gray-500 fs-7 fw-semibold my-1">Data</small>
                <!--end::Description-->
            </h1>
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->

<!--begin::Container-->
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Row-->
        <div class="row g-5 g-lg-10">
            <!--begin::Col-->
            <div class="row-xl-4">
                <!--begin::Mixed Widget 2-->
                <div>
                    <!--begin::Header-->
                    <div class="bg-gray-900 card-header border-0 p-20 rounded-top-2">
                        <h2 class="card-title fw-bold text-white">
                            Anda dapat mengajukan usulan <br />
                            terkait dengan layanan berikut :
                        </h2>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0">
                        <!--begin::Chart-->
                        <div class="mixed-widget-2-chart card-rounded-bottom bg-gray-900" style="height: 50px"></div>
                        <!--end::Chart-->
                        <!--begin::Stats-->
                        <div class="card-p mt-n20 position-relative">
                            <!--begin::Row-->
                            <div class="row g-0">
                                <!--begin::Col-->
                                <div class="col d-flex justify-content-lg-center bg-white px-6 py-12 rounded-2 me-7">
                                    <i class="bi bi-search fs-2 text-warning mt-4 mb-lg-0 mr-5px">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <a href="#" class="text-warning fw-bold fs-1 mr-5 mt-3 px-10">Pengabdian</a><a href="#" class="text-warning fw-bold fs-1 mr-5 mt-3 px-10">Penelitian</a>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col d-flex justify-content-lg-center bg-white px-6 py-12 rounded-2 me-7">
                                    <i class="bi bi-bookmarks fs-2x text-danger mt-3 mb-0 mr-5px"></i>
                                    <a href="#" class="text-danger fw-bold fs-2 mr-5 mt-3 px-10">Kekayaan Intelektual</a>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 2-->
            </div>
            <!--end::Col-->
        </div>

        <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
            <h1 class="d-flex bs-primary-text-emphasis fw-bold m-0 fs-3 pb-4">
                Status Usulan Terakhir
            </h1>
        </div>
        <div class="bg-white card-header border-0 p-20 rounded-2 mb-4 h-250px"></div>

        <!--begin::Row-->
        <h1 class="d-flex bs-primary-text-emphasis fw-bold m-0 fs-3 mt-10 mb-4">
            Profil Anda
        </h1>

        <!-- Stats Cards Row 1 -->
        <div class="row d-flex flex-wrap g-lg-10 h-100">
            <!-- Identitas Card -->
            <div class="col-xl-4 mb-xl-10">
                <div class="card">
                    <div class="card-body h-auto">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Identitas</a>
                        <div class="d-flex justify-content-between">
                            <p class="text-gray-900-75 fw-bold fs-2 m-0 pt-3">
                              akmal
                            </p>
                            <div class="small-circle mb-5 d-flex align-items-center justify-content-lg-center">
                                <i class="bi bi-person-circle fs-2tx text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Penelitian Card -->
            <div class="col">
                <div class="card">
                    <div class="card-body h-auto">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Penelitian</a>
                        <div class="d-flex justify-content-between">
                            <p class="text-gray-900-75 fw-bold fs-1 m-0 p-3">asdds</p>
                            <div class="small-circle mb-5 d-flex align-items-center justify-content-lg-center">
                                <i class="bi bi-search fs-2tx text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pengabdian Card -->
            <div class="col-xl-4 mb-5 mb-lg-10">
                <div class="card">
                    <div class="card-body h-auto">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Pengabdian</a>
                        <div class="d-flex justify-content-between">
                            <p class="text-gray-900-75 fw-bold fs-1 m-0 p-3">asdsad</p>
                            <div class="small-circle mb-5 d-flex align-items-center justify-content-lg-center">
                                <i class="bi bi-star fs-2tx text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row 2 -->
        <div class="row d-flex flex-wrap g-lg-10 h-100">
            <!-- Jurnal Internasional Card -->
            <div class="col-xl-4 mb-xl-10">
                <div class="card">
                    <div class="card-body h-auto">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Artikel pada Jurnal Internasional Bereputasi</a>
                        <div class="d-flex justify-content-between">
                            <p class="text-gray-900-75 fw-bold fs-1 m-0 pt-3">asdd</p>
                            <div class="small-circle mb-5 d-flex align-items-center justify-content-center">
                                <i class="bi bi-tag fs-2tx text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sinta Skor Card -->
            <div class="col">
                <div class="card">
                    <div class="card-body h-auto">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Sinta Skor Overall</a>
                        <div class="d-flex justify-content-between">
                            <p class="text-gray-900-75 fw-bold fs-1 m-0 p-3">sadad</p>
                            <div class="small-circle mb-5 d-flex align-items-center justify-content-lg-center">
                                <i class="bi bi-tag fs-2tx text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- HKI Card -->
            <div class="col-xl-4 mb-5 mb-lg-10">
                <div class="card">
                    <div class="card-body h-auto">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">HKI</a>
                        <div class="d-flex justify-content-between">
                            <p class="text-gray-900-75 fw-bold fs-1 m-0 p-3">dsa</p>
                            <div class="small-circle mb-5 d-flex align-items-center justify-content-lg-center">
                                <i class="bi bi-tag fs-2tx text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row 3 -->
        <div class="row d-flex flex-wrap g-lg-10 h-100">
            <!-- Buku Card -->
            <div class="col-xl-4 mb-xl-10">
                <div class="card">
                    <div class="card-body h-auto">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Buku</a>
                        <div class="d-flex justify-content-between">
                            <p class="text-gray-900-75 fw-bold fs-1 m-0 pt-3">sda</p>
                            <div class="small-circle mb-5 d-flex align-items-center justify-content-center">
                                <i class="bi bi-tag fs-2tx text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sinta 3Yr Card -->
            <div class="col">
                <div class="card">
                    <div class="card-body h-auto">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Sinta Skor 3Yr</a>
                        <div class="d-flex justify-content-between">
                            <p class="text-gray-900-75 fw-bold fs-1 m-0 p-3">sda</p>
                            <div class="small-circle mb-5 d-flex align-items-center justify-content-lg-center">
                                <i class="bi bi-tag fs-2tx text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Scopus H-Index Card -->
            <div class="col-xl-4 mb-5 mb-lg-10">
                <div class="card">
                    <div class="card-body h-auto">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Scopus H-Index</a>
                        <div class="d-flex justify-content-between">
                            <p class="text-gray-900-75 fw-bold fs-1 m-0 p-3">asd</p>
                            <div class="small-circle mb-5 d-flex align-items-center justify-content-lg-center">
                                <i class="bi bi-tag fs-2tx text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Detail Section -->
        <div class="bg-light-primary border-0 rounded-top-2 h-100px">
            <div class="d-flex justify-content-between">
                <div class="col">
                    <p class="fs-1 text-primary fw-bolder pt-5 px-8 mb-1">
                       akmal
                    </p>
                    <p class="text-primary fw-bold px-8 fs-6">Program Studi Ti</p>
                </div>
                <div class="symbol symbol-100px symbol-square d-flex justify-content-end">
                    <div class="symbol-label fs-1 fw-bold text-success">
                       asd
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border-0 card-rounded-bottom h-500px">
            <div class="container">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6 px-2 pt-7 fs-4">
                        <p class="mb-0"><strong>NIDN/NIDK</strong></p>
                        <p class="text-primary">asd</p>

                        <p class="mb-0"><strong>Klaster</strong></p>
                        <p class="text-primary">asd</p>

                        <p class="mb-0"><strong>Institusi</strong></p>
                        <p class="text-primary">Universitas Muslim Indonesia</p>

                        <p class="mb-0"><strong>Program Studi</strong></p>
                        <p class="text-primary">asd</p>

                        <p class="mb-0"><strong>Jenjang Pendidikan</strong></p>
                        <p class="text-primary">sda</p>

                        <p class="mb-0"><strong>Jabatan Akademik</strong></p>
                        <p class="text-primary">dsa</p>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6 pt-7 fs-4">
                        <p class="mb-0"><strong>Alamat</strong></p>
                        <p class="text-primary">dsa</p>

                        <p class="mb-0"><strong>Tempat, Tanggal Lahir</strong></p>
                        <p class="text-primary">
                            sad
                        </p>

                        <p class="mb-0"><strong>No KTP</strong></p>
                        <p class="text-primary">dsa</p>

                        <p class="mb-0"><strong>No HP</strong></p>
                        <p class="text-primary">sda</p>

                        <p class="mb-0"><strong>Alamat Surel</strong></p>
                        <p class="text-primary">sda</p>

                        <p class="mb-0"><strong>Website Personal</strong></p>
                        <p class="text-primary">dsa</p>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="#" class="btn btn-outline btn-outline-primary btn-active-light-primary fw-bold text-primary">
                        <i class="bi bi-arrow-repeat me-lg-2 text-primary fw-bold"></i>Sync PDDIKTI
                    </a>
                    <a href="#" class="btn btn-bg-warning text-white fw-bold">
                        <i class="bi bi-pen-fill me-lg-2 text-white"></i>Sunting
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->
</div>
<!--end::Container-->

<style>
    .small-circle {
        width: 70px;
        height: 70px;
        background-color: blue;
        border-radius: 50%;
    }
</style>
@endsection