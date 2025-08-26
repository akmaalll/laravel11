@extends('app.layouts.index', ['pengajuan_judul' => true])

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
                <!--begin::Col-->
                <div class="col-xl-12 mb-xl-10">
                    <!--begin::Tables Widget 3-->
                    <div class="card h-xl-100">
                        <!--begin::Body-->
                        <div class="card-body py-3 mt-5">

                            <!--begin::Step-->
                            @include('app.pengajuan-judul._stepHeader')
                            <!--end::Step-->

                            <!--begin::Form-->
                            <form class="form" id="kt_formvalidation_step" action="#" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="step" name="step" value="{{ $currentStep ?? 2 }}">
                                <input type="hidden" name="id" id="formId" value="{{ $uuid ?? null }}">

                                <div class="mb-5">
                                    <!--begin::Step 1-->
                                    @include('app.pengajuan-judul._step2')
                                    <!--End::Step 1-->
                                </div>

                                <div class="separator separator-dashed my-10"></div>

                                <!--begin::Actions-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Wrapper-->
                                    <div class="me-2">
                                        <button type="button" class="btn btn-light btn-active-light-primary"
                                            id="backStep1">
                                            <- Back </button>
                                    </div>
                                    <!--end::Wrapper-->

                                    <!--begin::Wrapper-->
                                    <div class="mb-5">
                                        <button type="button" id="kt_formvalidation_step_submit"
                                            class="btn btn-primary kt_formvalidation_step_submit" data-id="submit">
                                            <span class="indicator-label">Continue -></span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form-->

                        </div>
                        <!--begin::Body-->
                    </div>
                    <!--end::Tables Widget 3-->
                </div>
                <!--end::Col-->

            </div>
            <!--end::Row-->

        </div>
        <!--end::Post-->
    </div>
@endsection

@push('jsScript')
    @include('app.pengajuan-judul.js.submitAndDraf')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const savedJudul = localStorage.getItem('judul_pengajuan');
            if (savedJudul) {
                document.getElementById('judul').value = savedJudul;
            }

            const savedTopic = localStorage.getItem('predicted_topic_name');
            const savedTopicId = localStorage.getItem('predicted_topic_id');
            
            if (savedTopic) {
                document.getElementById('topik').value = savedTopic;
                document.getElementById('id_topik').value = savedTopicId;
            }
        });

        $(document).ready(function() {

            $('#backStep1').on('click', function() {
                setTimeout(function() {
                    window.location.replace("{{ route('pengajuan.step1') }}");
                }, 750);
            });


        })
    </script>
@endpush
