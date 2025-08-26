@extends('app.layouts.index', ['pengajuan_judul' => true])

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">Pengajuan Judul
                    <span class="h-20px border-gray-500 border-start mx-3"></span>
                    <small class="text-gray-500 fs-7 fw-semibold my-1">Data</small>
                </h1>
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">


            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!--begin::Alert-->
                <div class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5 mb-4">
                    <!--begin::Icon-->
                    <i class="ki-duotone ki-notification-bing fs-2hx text-primary me-4 mb-5 mb-sm-0"><span
                            class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column pe-0 pe-sm-10">
                        <!--begin::Title-->
                        <h5 class="fw-semibold">Informasi Usulan Judul Tugas Akhir</h5>
                        <!--end::Title-->

                        <!--begin::Content-->
                        <span>
                            1.⁠ ⁠Mahasiswa wajib membaca panduan penulisan tugas akhir sebelum mengusulkan judul.<br>
                            2.⁠ ⁠Mahasiswa Universitas Dipa Makassar yang sedang menempuh tugas akhir wajib mengajukan
                            usulan judul sesuai dengan bidang keahlian program studi.<br>
                            3. Setiap mahasiswa dapat : <br>
                            <span>&nbsp; &bull; &nbsp;Mengusulkan maksimal 3 judul alternatif untuk dipilih dosen
                                pembimbing</span><br>
                            <span>&nbsp; &bull; &nbsp;Melakukan revisi judul sesuai masukan dosen pembimbing</span><br>
                            <span>&nbsp; &bull; &nbsp;Mengganti judul jika belum disetujui oleh koordinator program
                                studi</span>
                        </span>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Alert-->

                <!--begin::Tables Widget 10-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                        <!--begin::Card title-->
                        <div class="card-title">
                            <div class="w-100 mw-100px me-3">
                                <select class="form-select form-select-sm" data-control="select2" data-hide-search="true"
                                    data-placeholder="Per Page" id="perPage">
                                    <option>5</option>
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                            </div>
                            <div class="d-flex align-items-center position-relative my-1 me-3">
                                <input type="text" class="form-control form-control-sm w-200px" placeholder="Cari..."
                                    id="pencarian" />
                            </div>
                            <div class="w-50 mw-50px">
                                <a onclick="" id="btnSearch" class="searchData">
                                    <button class="btn btn-sm fw-bold btn-secondary">
                                        <span class="btn-label">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        @if ($data < 3)
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                <a href="{{ route('pengajuan.step1') }}" class="btn btn-sm fw-bold btn-primary">
                                    <span class="btn-label">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    Create
                                </a>
                            </div>
                        @endif
                        <!--end::Card toolbar-->

                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body pt-3">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bold text-gray-700">
                                        <th width="6%">No</th>
                                        <th width="20%">Nama Mahasiswa</th>
                                        <th width="*">Judul</th>
                                        <th width="*">Topik</th>
                                        <th width="15%">Pembimbing 1</th>
                                        <th width="15%">Pembimbing 2</th>
                                        <th width="*">Status</th>
                                        <th width="*" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="datatables">
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex flex-wrap py-2 mr-3">
                                <div class="text-center pagination">
                                    <div id="contentx"></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center py-3">
                                <ul class="pagination twbs-pagination">
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!--begin::Body-->
                </div>
                <!--end::Tables Widget 10-->

            </div>
            <!--end::Content container-->
        </div>
    </div>
    <!--end::Content-->

    <div class="modal fade" id="modalDetailJudul" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Detail Pengajuan Judul</h5>
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-2"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-rounded border gy-5 gs-5">
                            <tbody>
                                <tr>
                                    <th class="fw-semibold w-25">Judul</th>
                                    <td id="judul"></td>
                                </tr>
                                <tr>
                                    <th class="fw-semibold">Topik</th>
                                    <td id="topik"></td>
                                </tr>
                                <tr>
                                    <th class="fw-semibold">NIM 1</th>
                                    <td id="nim1"></td>
                                </tr>
                                <tr>
                                    <th class="fw-semibold">NIM 2</th>
                                    <td id="nim2"></td>
                                </tr>
                                <tr>
                                    <th class="fw-semibold">Status</th>
                                    <td>
                                        <span id="status" class="badge fw-bold"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('jsScript')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.detail-judul', function() {
                let id = $(this).data('id');

                $.get("{{ url('/mahasiswa/pengajuan-judul') }}/" + id + "/detail", function(data) {
                    console.log(data);
                    if (data.success === false) {
                        toastr.error(data.message);
                        return;
                    }

                    $('#judul').text(data.judul);
                    $('#nim1').text(data.nim1 + ' - ' + data.nama_mhs1);
                    $('#nim2').text(data.nim2 ? data.nim2 + ' - ' + data.nama_mhs2 : '-');
                    $('#topik').text(data.nama_keahlian ?? '-');

                    let statusClass = 'badge-secondary';
                    if (data.status === 'diterima') statusClass = 'badge-success';
                    else if (data.status === 'diajukan') statusClass = 'badge-warning';
                    else if (data.status === 'ditolak') statusClass = 'badge-danger';

                    $('#status').removeClass().addClass('badge ' + statusClass).text(data.status);

                    $('#modalDetailJudul').modal('show');
                }).fail(function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Gagal memuat data');
                });
            });


            // Approve
            $(document).on('click', '.btn-approve', function(e) {
                e.preventDefault();
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin approve?',
                    text: "Judul ini akan diajukan.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Approve',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/mahasiswa/pengajuan-judul/judul/' + id + '/approve',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    loaddata(3, 10, '');
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON?.message ||
                                    'Terjadi kesalahan.');
                            }
                        });
                    }
                });
            });

            // Reject
            $(document).on('click', '.btn-reject', function(e) {
                e.preventDefault();
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Tolak judul ini?',
                    text: "Judul akan terhapus di akun anda.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/mahasiswa/pengajuan-judul/judul/' + id + '/reject',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    loaddata(3, 10, '');
                                    toastr.success(response.message);
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON?.message ||
                                    'Terjadi kesalahan.');
                            }
                        });
                    }
                });

                // $(document).on('click', '.btn-hapus', function(e) {
                //     e.preventDefault();
                //     let id = $(this).data('id');

                //     if (confirm('Yakin ingin menghapus judul ini?')) {
                //         $.ajax({
                //             url: '/mahasiswa/pengajuan-judul/' + id + '/hapus',
                //             type: 'DELETE',
                //             data: {
                //                 _token: '{{ csrf_token() }}'
                //             },
                //             success: function(response) {
                //                 if (response.status === 'success') {
                //                     alert(response.message);
                //                     location.reload(); // refresh table
                //                 } else {
                //                     alert(response.message);
                //                 }
                //             },
                //             error: function(xhr) {
                //                 alert('Terjadi kesalahan saat menghapus data.');
                //             }
                //         });
                //     }
                // });

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
                        url: "{{ route('pengajuan.data') }}",
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
                        url: "{{ route('pengajuan.data') }}",
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
                                $(".datatables").html(
                                    '<tr><td colspan="4">Data not found</td></tr>');
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
                                        var to = page * per_page - (per_page -
                                            1);
                                    }
                                    if (page == response.total_page) {
                                        var end = response.total_data;
                                    } else {
                                        var end = page * per_page;
                                    }
                                    $('#contentPage').text('Showing ' + to +
                                        ' to ' + end +
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
                    url: "{{ route('pengajuan.data') }}",
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
                    url: "{{ route('pengajuan.data') }}",
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
                            url: '{{ url('mahasiswa/pengajuan-judul') }}/' + id,
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
