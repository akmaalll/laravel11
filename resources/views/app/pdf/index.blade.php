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
                                    Perjanjian Kinerja
                                </h1>
                            </li>

                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>

                            <li class="breadcrumb-item text-muted">
                                Data
                            </li>
                            <!--end::Item-->

                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Toolbar container-->
            </div>

            <!--begin::Card-->
            <div class="card">
                <div class="my-5 mx-5">
                    <embed src="{{ asset('uploads/dokumen/' . $dokumen) }}" width="100%" height="600px"
                        type="application/pdf">
                </div>

                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <div class="mw-100px me-3">
                            <select class="form-select form-select-solid me-3" data-control="select2"
                                data-hide-search="true" data-placeholder="Per Page" id="perPage">
                                <option>15</option>
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
                    <!--begin::Card title-->
                </div>
                <!--end::Card header-->

                <div class="card-body py-4 table-responsive">

                    <!--begin::Table-->
                    <table class="table align-middle table-hover table-row-dashed fs-6 table-row-gray-500 gy-3">
                        <tbody class="text-gray-600 fw-semibold datatables">
                            {{-- <div class="mt-5 mx-5">
                                <h4>Data Indikator Tahun {{ $tahun }}</h4>
                                @if ($indikatorData->isNotEmpty())
                                    @foreach ($indikatorData as $indikator)
                                        <div class="mb-3">
                                            <p><strong>Indikator:</strong> {{ $indikator->indikator }}</p>
                                            <p><strong>Definisi Operasional:</strong> {{ $indikator->definisi_operasional }}
                                            </p>
                                            <hr>
                                        </div>
                                    @endforeach
                                @else
                                    <p>Tidak ada indikator untuk tahun ini.</p>
                                @endif
                            </div> --}}
                        </tbody>
                    </table>
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



            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

@push('jsScript')
    <script type="text/javascript">
        $(document).ready(function() {
            loadpage(10, '');
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
                    url: "{{ url('pdf/data') }}",
                    data: {
                        "page": page,
                        "per_page": per_page,
                        "search": search,
                    },
                    type: "GET",
                    datatype: "json",
                    success: function(data) {
                        $(".datatables").html(data.html);
                        initTooltips();
                        ShowLinkData();
                    }
                });
            }

            function ShowLinkData() {
                $(document).off('click', '.show-image').on('click', '.show-image', function(e) {
                    e.preventDefault();
                    let imageUrl = $(this).attr('data-image');

                    let fileExtension = imageUrl.split('.').pop().toLowerCase();
                    if (fileExtension == 'pdf') {
                        window.open(imageUrl, '_blank');
                    } else {
                        $('#modalImage').attr('src', imageUrl);
                        $('#kt_modal_1').modal('show');
                        // console.error('No image URL found');
                    }
                });
            }


            function initTooltips() {
                const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');

                tooltipElements.forEach(element => {
                    const existingTooltip = bootstrap.Tooltip.getInstance(element);
                    if (existingTooltip) {
                        existingTooltip.dispose();
                    }

                    const title = element.getAttribute('data-bs-title');

                    if (title) {
                        new bootstrap.Tooltip(element, {
                            html: true,
                            sanitize: false,
                            title: title,
                            container: 'body'
                        });
                    }
                });
            }

            function loadpage(per_page, search) {
                $.ajax({
                    url: "{{ url('pdf/data') }}",
                    data: {
                        "per_page": per_page,
                        "search": search,
                    },
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if ($pagination.data("twbs-pagination")) {
                            console.log(response);
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
                        initTooltips();
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
                loadpage(15, '');
            });

        });

        const slider = document.querySelector('.parentx');
        let mouseDown = false;
        let startX, scrollLeft;

        let startDragging = function(e) {
            mouseDown = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        };
        let stopDragging = function(event) {
            mouseDown = false;
        };

        // slider.addEventListener('mousemove', (e) => {
        //     e.preventDefault();
        //     if (!mouseDown) {
        //         return;
        //     }
        //     const x = e.pageX - slider.offsetLeft;
        //     const scroll = x - startX;
        //     slider.scrollLeft = scrollLeft - scroll;
        // });

        // // Add the event listeners
        // slider.addEventListener('mousedown', startDragging, false);
        // slider.addEventListener('mouseup', stopDragging, false);
        // slider.addEventListener('mouseleave', stopDragging, false);
    </script>
@endpush
