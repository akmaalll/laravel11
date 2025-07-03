@extends('app.layouts.index')

@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">



            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <div class="mw-100px me-3">
                            <select class="form-select form-select-solid me-3" data-control="select2" data-hide-search="true"
                                data-placeholder="Per Page" id="perPage">
                                {{-- <option>5</option> --}}
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
                    <!--begin::Card title-->
                </div>
                <!--end::Card header-->

                <!-- Modal -->
                <div class="modal fade" tabindex="-1" id="kt_modal_1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Link Data Dukung</h3>

                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </div>
                                <!--end::Close-->
                            </div>

                            <div class="modal-body">
                                <img id="modalImage" src="" alt="Data Dukung" class="img-fluid">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->

                <div class="parentx">
                    <div class="childx">


                        <div class="card-body py-4 table-responsive">

                            <!--begin::Table-->
                            <table class="table align-middle table-hover table-row-dashed fs-6 table-row-gray-400 gy-3">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0 text-center"
                                        style="background-color: #f9fbfc">
                                        <th class="w-10px pe-2">No</th>
                                        <th class="min-w-350px">Rencana Kerja</th>
                                        <th class="min-w-350px">Indikator Kinerja</th>
                                        <th class="min-w-125px">Target</th>
                                        <th class="min-w-125px">PIC</th>
                                        <th class="min-w-125px">Januari</th>
                                        <th class="min-w-125px">Februari</th>
                                        <th class="min-w-125px">Maret</th>
                                        <th class="min-w-125px">TW 1</th>
                                        <th class="min-w-125px">Kendala TW1</th>
                                        <th class="min-w-125px">Tindak Lanjut TW1</th>
                                        <th class="min-w-125px">April</th>
                                        <th class="min-w-125px">Mei</th>
                                        <th class="min-w-125px">Juni</th>
                                        <th class="min-w-125px">TW 2</th>
                                        <th class="min-w-125px">Kendala TW2</th>
                                        <th class="min-w-125px">Tindak Lanjut TW2</th>
                                        <th class="min-w-125px">Semester 1</th>
                                        <th class="min-w-125px">Juli</th>
                                        <th class="min-w-125px">Agustus</th>
                                        <th class="min-w-125px">September</th>
                                        <th class="min-w-125px">TW 3</th>
                                        <th class="min-w-125px">Kendala TW3</th>
                                        <th class="min-w-125px">Tindak Lanjut TW3</th>
                                        <th class="min-w-125px">Oktober</th>
                                        <th class="min-w-125px">November</th>
                                        <th class="min-w-125px">Desember</th>
                                        <th class="min-w-125px">TW 4</th>
                                        <th class="min-w-125px">Kendala TW4</th>
                                        <th class="min-w-125px">Tindak Lanjut TW4</th>
                                        <th class="min-w-125px">Semester 2</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-semibold datatables">
                                </tbody>
                            </table>
                            <!--end::Table-->

                            <!--begin::Pagination-->
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="d-flex flex-wrap py-2 mr-3">
                                    <div class="text-center pagination">
                                        <div id="contentPage"></div>
                                    </div>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    <ul class="pagination twbs-pagination">
                                    </ul>
                                </div>
                                <div class="d-flex align-items-center py-3">

                                </div>
                            </div>
                            <!--end::Pagination-->

                        </div>
                    </div>
                </div>
                <!--end::Card body-->


            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    {{-- <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="modalImage"
                        src="http://localhost:8888/bpfk-spt/public/uploads/triwulan/20241103_67279719efbac.png"
                        alt="Data Dukung" class="img-fluid">
                </div>
            </div>
        </div>
    </div> --}}
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
                    url: '{{ route('index.data') }}',
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
                    url: '{{ route('index.data') }}',
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
                loadpage(10, '');
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

        slider.addEventListener('mousemove', (e) => {
            e.preventDefault();
            if (!mouseDown) {
                return;
            }
            const x = e.pageX - slider.offsetLeft;
            const scroll = x - startX;
            slider.scrollLeft = scrollLeft - scroll;
        });

        // Add the event listeners
        slider.addEventListener('mousedown', startDragging, false);
        slider.addEventListener('mouseup', stopDragging, false);
        slider.addEventListener('mouseleave', stopDragging, false);
    </script>
@endpush
