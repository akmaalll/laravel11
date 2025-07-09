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
                            <!-- Pisahkan form cek judul -->

                            <div class="mb-5">
                                <!--begin::Step 1-->
                                @include('app.pengajuan-judul._step1')
                                <!--End::Step 1-->
                            </div>
                            <!--begin::Form-->
                            <form class="form" id="kt_formvalidation_step" action="#" autocomplete="off"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" id="step" name="step" value="{{ $currentStep ?? 1 }}">
                                <input type="hidden" name="id" id="formId" value="{{ $uuid ?? null }}">


                                <div class="separator separator-dashed my-10"></div>

                                <!--begin::Actions-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Wrapper-->
                                    <div class="me-2">
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

    <script type="text/javascript">
        async function checkTitle(event) {
            try {
                event.preventDefault();

                const judulInput = document.getElementById('judul');
                const checkBtn = document.getElementById('checkTitleBtn');
                const checkBtnText = document.getElementById('checkBtnText');
                const resultDiv = document.getElementById('titleCheckResult');
                const submitButton = document.getElementById('kt_formvalidation_step_submit');

                // Validate input
                const title = judulInput.value.trim();
                if (!title) {
                    toastr.error('Silakan masukkan judul terlebih dahulu');
                    return;
                }

                // Show loading state
                checkBtnText.innerHTML =
                    '<span class="spinner-border spinner-border-sm"></span> Sedang menganalisis...';
                checkBtn.disabled = true;
                resultDiv.innerHTML = `
                <div class="alert alert-info">
                    <strong>Memproses...</strong>
                    <div class="mt-2">
                        <div class="d-flex justify-content-between">
                            <span>Cosine Similarity: 0%</span>
                            <span>SVM Prediction: -</span>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            `;
                resultDiv.style.display = 'block';

                // Send request to server
                const response = await fetch('{{ route('check.title.similarity') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        judul: title
                    })
                });

                const data = await response.json();

                if (data.predicted_topic) {
                    localStorage.setItem('predicted_topic', data.predicted_topic);
                }

                if (!response.ok) {
                    throw new Error(data.message || 'Terjadi kesalahan saat menganalisis judul');
                }

                // Display combined results
                displayAnalysisResult(data);

            } catch (error) {
                console.error('Error:', error);
                toastr.error(error.message || 'Terjadi kesalahan saat menganalisis judul');
                document.getElementById('titleCheckResult').innerHTML = `
                <div class="alert alert-danger">
                    ${error.message || 'Terjadi kesalahan saat menganalisis judul'}
                </div>
            `;
            } finally {
                // Reset button state
                const checkBtnText = document.getElementById('checkBtnText');
                if (checkBtnText) {
                    checkBtnText.textContent = 'Analisis Judul';
                }
                const checkBtn = document.getElementById('checkTitleBtn');
                if (checkBtn) {
                    checkBtn.disabled = false;
                }
            }
        }

        function displayAnalysisResult(data) {
            console.log(data)
            const resultDiv = document.getElementById('titleCheckResult');
            const submitButton = document.getElementById('kt_formvalidation_step_submit');
            const cosinePercent = Math.round(data.similarity * 100);
            const svmPrediction = data.predicted_topic || 'Tidak dapat diprediksi';

            // Determine overall status
            let overallStatus, alertClass;
            if (cosinePercent < 30) {
                overallStatus = '✅ Judul Diterima!';
                alertClass = 'alert-success';
                if (submitButton) submitButton.disabled = false;
            } else if (cosinePercent < 70) {
                overallStatus = '⚠️ Perlu Modifikasi!';
                alertClass = 'alert-warning';
                if (submitButton) submitButton.disabled = false;
            } else {
                overallStatus = '❌ Judul Ditolak!';
                alertClass = 'alert-danger';
                if (submitButton) submitButton.disabled = true;
            }

            // Build similar titles list
            let similarTitlesList = '';
            if (data.similar_titles && data.similar_titles.length > 0) {
                similarTitlesList = `
                <div class="mt-3">
                    <strong>Judul yang mirip:</strong>
                    <ul class="mt-2">
                        ${data.similar_titles.map(title => `
                                                    <li>${title.judul} (${Math.round(title.similarity * 100)}% similar, Topik: ${title.topik})</li>
                                                `).join('')}
                    </ul>
                </div>
            `;
            }

            // Build recommendations
            const recommendations = `
            <div class="mt-3">
                <strong>Saran:</strong>
                <ul class="mt-2">
                    <li>Prediksi Topik (SVM): <strong>${svmPrediction}</strong></li>
                    <li>Tambahkan spesifikasi yang lebih detail</li>
                    <li>Ubah fokus penelitian</li>
                </ul>
            </div>
            ${similarTitlesList}
        `;

            resultDiv.innerHTML = `
            <div class="alert ${alertClass}">
                <strong>${overallStatus}</strong>
                <div class="mt-2">
                    <div class="d-flex justify-content-between">
                        <span>Cosine Similarity: ${cosinePercent}%</span>
                        <span>SVM Prediction: ${svmPrediction}</span>
                    </div>
                    <div class="progress mt-1">
                        <div class="progress-bar" role="progressbar" 
                             style="width: ${cosinePercent}%" 
                             aria-valuenow="${cosinePercent}" 
                             aria-valuemin="0" 
                             aria-valuemax="100"></div>
                    </div>
                </div>
                ${cosinePercent >= 30 ? recommendations : ''}
            </div>
        `;
        }

        function resetTitleCheck() {
            document.getElementById('judul').value = '';
            document.getElementById('titleCheckResult').style.display = 'none';
            const submitButton = document.getElementById('kt_formvalidation_step_submit');
            if (submitButton) submitButton.disabled = false;
        }

        function getRecommendations(similarTitles = []) {
            let similarTitlesHtml = '';
            if (similarTitles.length > 0) {
                similarTitlesHtml = `
            <div class="mt-3">
                <strong>Judul yang mirip:</strong>
                <ul class="mt-1">
                    ${similarTitles.map(title => 
                        `<li>${title.judul} (${Math.round(title.similarity * 100)}%)</li>`
                    ).join('')}
                </ul>
            </div>
        `;
            }

            return `
        <div class="mt-3">
            <strong>Saran:</strong>
            <ul class="mt-1">
                <li>Tambahkan spesifikasi yang lebih detail</li>
                <li>Ubah fokus penelitian</li>
                <li>Tambahkan lokasi atau tahun penelitian</li>
            </ul>
            ${similarTitlesHtml}
        </div>
    `;
        }

        // Initialize with saved title if exists
        document.addEventListener('DOMContentLoaded', function() {
            const savedJudul = localStorage.getItem('saved_judul');
            if (savedJudul) {
                document.getElementById('judul').value = savedJudul;
            }

            document.getElementById('judul').addEventListener('input', function() {
                localStorage.setItem('saved_judul', this.value);
            });
        });
    </script>
@endpush
