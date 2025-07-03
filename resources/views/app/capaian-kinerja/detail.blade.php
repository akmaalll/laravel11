@extends('app.layouts.index')

@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">

        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="  container-fluid d-flex flex-stack ">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <h1
                                    class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                                    Rencan Hasil Kerja
                                </h1>
                            </li>

                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>

                            <li class="breadcrumb-item text-muted">
                                <a href="{{ url('/capaian-kinerja') }}" class="text-muted text-hover-primary">
                                    Data
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>

                            <li class="breadcrumb-item text-muted">
                                Detail
                            </li>
                            <!--end::Item-->

                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Toolbar container-->
            </div>

            <!--begin::FAQ card-->
            <div class="card">
                <!--begin::Body-->
                <div class="card-body p-lg-15">
                    <!--begin::Classic content-->
                    <div class="mb-10">
                        <!--begin::Intro-->
                        <div class="mb-10">
                            <h4 class="fs-2 text-gray-800 w-bolder mb-4"> {{ $data->rencanaKerja->rencana ?? '' }}</h4>
                            <p class="fw-semibold fs-5 text-gray-600 mb-2">{{ $data->indikatorKinerja->indikator ?? '' }}
                            </p>
                        </div>
                        <!--end::Intro-->
                        <!--begin::Row-->
                        <div class="row mb-12">
                            <!--begin::Col-->
                            <div class="col-md-12 pe-md-10 mb-10 mb-md-0">

                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle mb-0"
                                        data-bs-toggle="collapse" data-bs-target="#kt_job_4_1">
                                        <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                            <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                        <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">Triwulan I</h4>
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div id="kt_job_4_1" class="collapse  fs-6 ms-1">
                                        <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                                            <table
                                                class="table align-middle table-hover table-row-dashed fs-6 table-row-gray-500 gy-3">
                                                <thead>
                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"
                                                        style="background-color: #f9fbfc">
                                                        <th class="min-w-75px">Bulan</th>
                                                        <th class="min-w-350px">Keterangan</th>
                                                        <th class="min-w-350px">File Pendukung</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600 fw-semibold">
                                                    <tr>
                                                        <td>Januari</td>
                                                        <td>{{ $data->januari_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'Januari') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Februari</td>
                                                        <td>{{ $data->februari_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'Februari') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Maret</td>
                                                        <td>{{ $data->maret_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'Maret') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--end::Content-->
                                    <div class="separator separator-dashed"></div>
                                </div>

                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle mb-0"
                                        data-bs-toggle="collapse" data-bs-target="#kt_job_4_2">
                                        <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                            <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                        <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">Triwulan II</h4>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div id="kt_job_4_2" class="collapse fs-6 ms-1">
                                        <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                                            <table
                                                class="table align-middle table-hover table-row-dashed fs-6 table-row-gray-500 gy-3">
                                                <thead>
                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"
                                                        style="background-color: #f9fbfc">
                                                        <th class="min-w-75px">Bulan</th>
                                                        <th class="min-w-350px">Keterangan</th>
                                                        <th class="min-w-350px">File Pendukung</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600 fw-semibold">
                                                    <tr>
                                                        <td>April</td>
                                                        <td>{{ $data->april_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'April') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mei</td>
                                                        <td>{{ $data->mei_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'Mei') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Maret</td>
                                                        <td>{{ $data->juni_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'Juni') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--end::Content-->
                                    <div class="separator separator-dashed"></div>
                                </div>

                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle mb-0"
                                        data-bs-toggle="collapse" data-bs-target="#kt_job_4_3">
                                        <!--begin::Icon-->
                                        <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                            <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">Triwulan III</h4>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div id="kt_job_4_3" class="collapse fs-6 ms-1">
                                        <!--begin::Text-->
                                        <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                                            <table
                                                class="table align-middle table-hover table-row-dashed fs-6 table-row-gray-500 gy-3">
                                                <thead>
                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"
                                                        style="background-color: #f9fbfc">
                                                        <th class="min-w-75px">Bulan</th>
                                                        <th class="min-w-350px">Keterangan</th>
                                                        <th class="min-w-350px">File Pendukung</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600 fw-semibold">
                                                    <tr>
                                                        <td>Juli</td>
                                                        <td>{{ $data->juli_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'Juli') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Agustus</td>
                                                        <td>{{ $data->agustus_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'Agustus') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>September</td>
                                                        <td>{{ $data->september_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'September') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Content-->
                                    <div class="separator separator-dashed"></div>
                                </div>

                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle mb-0"
                                        data-bs-toggle="collapse" data-bs-target="#kt_job_4_4">
                                        <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                            <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                        <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">Triwulan IV</h4>
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div id="kt_job_4_4" class="collapse  fs-6 ms-1">
                                        <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                                            <table
                                                class="table align-middle table-hover table-row-dashed fs-6 table-row-gray-500 gy-3">
                                                <thead>
                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"
                                                        style="background-color: #f9fbfc">
                                                        <th class="min-w-75px">Bulan</th>
                                                        <th class="min-w-350px">Keterangan</th>
                                                        <th class="min-w-350px">File Pendukung</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600 fw-semibold">
                                                    <tr>
                                                        <td>Oktober</td>
                                                        <td>{{ $data->oktober_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'Oktober') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>November</td>
                                                        <td>{{ $data->november_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'November') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Desember</td>
                                                        <td>{{ $data->desember_realisasi }}</td>
                                                        <td>
                                                            @foreach (Helper::getFilePendukung($data->id, 'Desember') as $jan)
                                                                <a href="{{ asset('storage/file_pendukung/' . $jan->file) }}"
                                                                    target="_blank">{{ $jan->file }}</a><br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--end::Content-->
                                    <div class="separator separator-dashed"></div>
                                </div>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            {{-- <div class="col-md-6 ps-md-10">
                                <!--begin::Title-->
                                <h2 class="text-gray-800 fw-bold mb-4">Installation</h2>
                                <!--end::Title-->
                                <!--begin::Accordion-->
                                <!--begin::Section-->
                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle mb-0"
                                        data-bs-toggle="collapse" data-bs-target="#kt_job_5_1">
                                        <!--begin::Icon-->
                                        <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                            <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">What platforms are
                                            compatible?</h4>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div id="kt_job_5_1" class="collapse show fs-6 ms-1">
                                        <!--begin::Text-->
                                        <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">First, a disclaimer
                                            – the entire process of writing a blog post often takes more than a
                                            couple of hours, even if you can type eighty words as per minute and
                                            your writing skills are sharp.</div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed"></div>
                                    <!--end::Separator-->
                                </div>
                                <!--end::Section-->
                            </div> --}}

                            <div class="d-flex text-end mt-10">
                                <a href="{{ url('capaian-kinerja') }}">
                                    <button type="button" class="btn btn-light-primary">
                                        Kembali
                                    </button>
                                </a>
                            </div>
                            <!--end::Col-->

                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Classic content-->

                </div>
                <!--end::Body-->
            </div>
            <!--end::FAQ card-->

        </div>
        <!--end::Content container-->

    </div>
    <!--end::Content-->
@endsection

@push('jsScript')
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
@endpush
