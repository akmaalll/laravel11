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
                                    data-hide-search="false" id="pengajuan_select" required>
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
                                    </button>
                                </div>
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
        $('#btn-get-recommendation').click(function() {
            let id = $('#pengajuan_select').val();
            if (!id) {
                alert('Pilih pengajuan dulu!');
                return;
            }
            // redirect ke route dengan ID
            window.location.href = "{{ url('/admin/judul-pengajuan') }}/" + id;
        });
    </script>
@endpush
