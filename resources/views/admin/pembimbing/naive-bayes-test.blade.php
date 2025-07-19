@extends('admin._layouts.index')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Test Naive Bayes Recommendation System</h3>
                    </div>
                    <div class="card-body">
                        <!-- Form untuk test recommendation -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pengajuan_id">Pilih Pengajuan Judul:</label>
                                    <select id="pengajuan_id" class="form-control">
                                        <option value="">Pilih pengajuan...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="button" class="btn btn-primary" onclick="getRecommendation()">
                                            <i class="fas fa-magic"></i> Get Recommendation
                                        </button>
                                        <button type="button" class="btn btn-success" onclick="trainModel()">
                                            <i class="fas fa-brain"></i> Train Model
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hasil Recommendation -->
                        <div id="recommendation-result" style="display: none;">
                            <h4>Hasil Rekomendasi Naive Bayes</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Dosen</th>
                                            <th>Score</th>
                                            <th>Keahlian</th>
                                            <th>Mata Kuliah</th>
                                            <th>History Bimbingan</th>
                                            <th>History Penelitian</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recommendation-table">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Loading -->
                        <div id="loading" style="display: none;" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p>Processing recommendation...</p>
                        </div>

                        <!-- Error Message -->
                        <div id="error-message" style="display: none;" class="alert alert-danger">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load pengajuan data
        $(document).ready(function() {
            loadPengajuanData();
        });

        function loadPengajuanData() {
            $.ajax({
                url: '/admin/pengajuan-judul/datas',
                method: 'GET',
                success: function(response) {
                    if (response.ok && response.data) {
                        let options = '<option value="">Pilih pengajuan...</option>';
                        response.data.forEach(function(pengajuan) {
                            options +=
                                `<option value="${pengajuan.id}">${pengajuan.judul} (${pengajuan.topik})</option>`;
                        });
                        $('#pengajuan_id').html(options);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading pengajuan data:', xhr);
                }
            });
        }

        function getRecommendation() {
            const pengajuanId = $('#pengajuan_id').val();

            if (!pengajuanId) {
                alert('Silakan pilih pengajuan judul terlebih dahulu');
                return;
            }

            showLoading();
            hideError();

            $.ajax({
                url: `/admin/pembimbing/recommendation-naive-bayes/${pengajuanId}`,
                method: 'GET',
                success: function(response) {
                    hideLoading();
                    if (response.success) {
                        displayRecommendation(response.data);
                    } else {
                        showError(response.message);
                    }
                },
                error: function(xhr) {
                    hideLoading();
                    showError('Terjadi kesalahan saat mengambil rekomendasi');
                    console.error('Error:', xhr);
                }
            });
        }

        function displayRecommendation(data) {
            const tableBody = $('#recommendation-table');
            tableBody.empty();

            data.recommendations.forEach(function(rec, index) {
                const row = `
            <tr>
                <td>${index + 1}</td>
                <td>
                    <strong>${rec.dosen.nama}</strong><br>
                    <small class="text-muted">${rec.dosen.nidn}</small>
                </td>
                <td>
                    <span class="badge badge-primary">${(rec.score * 100).toFixed(2)}%</span>
                </td>
                <td>
                    <small>${rec.attributes.keahlian.join(', ') || '-'}</small>
                </td>
                <td>
                    <small>${rec.attributes.mata_kuliah.join(', ') || '-'}</small>
                </td>
                <td>
                    <small>${rec.attributes.history_bimbingan.join(', ') || '-'}</small>
                </td>
                <td>
                    <small>${rec.attributes.history_penelitian.join(', ') || '-'}</small>
                </td>
            </tr>
        `;
                tableBody.append(row);
            });

            $('#recommendation-result').show();
        }

        function trainModel() {
            showLoading();
            hideError();

            $.ajax({
                url: '/admin/pembimbing/train-naive-bayes',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    hideLoading();
                    if (response.success) {
                        alert('Model berhasil dilatih!');
                    } else {
                        showError(response.message);
                    }
                },
                error: function(xhr) {
                    hideLoading();
                    showError('Terjadi kesalahan saat melatih model');
                    console.error('Error:', xhr);
                }
            });
        }

        function showLoading() {
            $('#loading').show();
            $('#recommendation-result').hide();
        }

        function hideLoading() {
            $('#loading').hide();
        }

        function showError(message) {
            $('#error-message').text(message).show();
        }

        function hideError() {
            $('#error-message').hide();
        }
    </script>
@endsection
