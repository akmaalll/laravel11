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
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                        <thead>
                            <tr class="text-start text-gray-600 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-20px pe-2"> No </th>
                                <th class="min-w-200px"> Prodi </th>
                                <th class="min-w-200px"> Nama Konsentrasi </th>
                                <th class="text-end min-w-70px"> Actions </th>
                            </tr>
                        </thead>

                        <tbody class="fw-semibold text-gray-600 datatables">
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



                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

@push('jsScript')
    <script type="text/javascript">
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
{{-- @push('jsScript')
    <script type="text/javascript">
        $(document).ready(function() {
            // Configuration
            const config = {
                defaultPerPage: 5,
                paginationOptions: {
                    totalPages: 1,
                    prev: '&#8672;',
                    next: '&#8674;',
                    first: '&#8676;',
                    last: '&#8677;',
                    visiblePages: 8
                }
            };

            // Initialize pagination
            const $pagination = $('.twbs-pagination');
            $pagination.twbsPagination(config.paginationOptions);

            // Initialize page
            loadPage(config.defaultPerPage, '');

            /**
             * Load data for specific page
             * @param {number} page - Page number
             * @param {number} perPage - Items per page
             * @param {string} search - Search query
             */
            function loadData(page, perPage, search) {
                return $.ajax({
                    url: '{{ route($title . '.data') }}',
                    data: {
                        page: page,
                        per_page: perPage,
                        search: search
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $(".datatables").html(data.html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Load data error:', error);
                        toastr.error("Failed to load data!");
                    }
                });
            }

            /**
             * Load page with pagination
             * @param {number} perPage - Items per page
             * @param {string} search - Search query
             */
            function loadPage(perPage, search) {
                $.ajax({
                    url: '{{ route($title . '.data') }}',
                    data: {
                        per_page: perPage,
                        search: search
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        // Destroy existing pagination
                        if ($pagination.data("twbs-pagination")) {
                            $pagination.twbsPagination('destroy');
                            $(".datatables").html('<tr><td colspan="4">Data not found</td></tr>');
                        }

                        // Initialize new pagination
                        $pagination.twbsPagination($.extend({}, config.paginationOptions, {
                            startPage: 1,
                            totalPages: response.total_page,
                            onPageClick: function(event, page) {
                                const startItem = page === 1 ? 1 : page * perPage - (
                                    perPage - 1);
                                const endItem = page === response.total_page ? response
                                    .total_data : page * perPage;

                                updatePageInfo(startItem, endItem, response.total_data);
                                loadData(page, perPage, search);
                            }
                        }));
                    },
                    error: function(xhr, status, error) {
                        console.error('Load page error:', error);
                        toastr.error("Failed to load page data!");
                    }
                });
            }

            /**
             * Update page information display
             * @param {number} start - Start item number
             * @param {number} end - End item number
             * @param {number} total - Total items
             */
            function updatePageInfo(start, end, total) {
                $('#contentPage').text(`Showing ${start} to ${end} of ${total} entries`);
            }

            /**
             * Generate expertise for all lecturers
             */
            function generateExpertise() {
                const $btn = $('#generate-keahlian-btn');
                const originalText = $btn.html();

                // Disable button and show loading
                $btn.prop('disabled', true)
                    .html('<span class="indicator-label"><i class="fas fa-cogs"></i> Processing...</span>');

                Swal.fire({
                    title: 'Generate Lecturer Expertise',
                    text: 'This will process all lecturer data. Continue?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, generate!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('keahlian.generate-all') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success'
                                    });
                                    // Refresh datatable
                                    refreshTable();
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                const errorMessage = xhr.responseJSON?.message ||
                                    'Process failed';
                                Swal.fire('Error!', errorMessage, 'error');
                                console.error('Generate expertise error:', xhr);
                            }
                        }).always(function() {
                            // Reset button state
                            $btn.prop('disabled', false).html(originalText);
                        });
                    } else {
                        // Reset button if cancelled
                        $btn.prop('disabled', false).html(originalText);
                    }
                });
            }

            /**
             * Delete data by ID
             * @param {number} id - Data ID to delete
             */
            function deleteData(id) {
                Swal.fire({
                    title: "Are you sure to delete?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                    confirmButtonColor: '#d33'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: `{{ url("admin/$title") }}/${id}`,
                            success: function(data) {
                                refreshTable();
                                toastr.success("Data deleted successfully!");
                            },
                            error: function(xhr) {
                                const errorMessage = xhr.responseJSON?.message ||
                                    'Failed to delete data';
                                toastr.error(errorMessage);
                                console.error('Delete error:', xhr);
                            }
                        });
                    }
                });
            }

            /**
             * Refresh table with current search and pagination
             */
            function refreshTable() {
                const search = $('#input_search').val();
                const perPage = $('#perPage').val() || config.defaultPerPage;

                if ($pagination.data("twbs-pagination")) {
                    $pagination.twbsPagination('destroy');
                }
                loadPage(perPage, search);
            }

            // Event Handlers
            $('#generate-keahlian-btn').on('click', generateExpertise);

            $("#button_search, #perPage").on('click change', function() {
                const search = $('#input_search').val();
                const perPage = $('#perPage').val() || config.defaultPerPage;
                loadPage(perPage, search);
            });

            $("#button_refresh").on('click', function() {
                $('#input_search').val('');
                loadPage(config.defaultPerPage, '');
            });

            // Delegated event for delete buttons
            $('body').on('click', '.deleteData', function() {
                const id = $(this).data("id");
                if (id) {
                    deleteData(id);
                } else {
                    toastr.error("Invalid data ID!");
                }
            });

            // Handle Enter key in search input
            $('#input_search').on('keypress', function(e) {
                if (e.which === 13) { // Enter key
                    $("#button_search").click();
                }
            });
        });
    </script>
@endpush --}}
