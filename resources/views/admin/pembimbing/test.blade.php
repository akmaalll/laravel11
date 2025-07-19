<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekomendasi Pembimbing</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .recommendation-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .recommendation-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .dosen-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .keahlian-badge {
            background: #e3f2fd;
            color: #1976d2;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin: 2px;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .method-selector {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .recommendation-result {
            display: none;
        }

        .score-indicator {
            width: 100%;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }

        .score-bar {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #ffc107, #dc3545);
            transition: width 0.3s ease;
        }

        /* Add CSRF token meta tag style */
        meta[name="csrf-token"] {
            display: none;
        }
    </style>
    <!-- Add CSRF token meta tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-brain"></i> Sistem Rekomendasi Pembimbing dengan Naive Bayes</h4>
                    </div>
                    <div class="card-body">

                        <!-- Pilihan Pengajuan -->
                        <div class="mb-4">
                            <label class="form-label">Pilih Pengajuan Judul:</label>
                            <select class="form-select" id="pengajuanSelect">
                                <option value="">-- Pilih Pengajuan --</option>
                                <!-- Options akan dimuat via JavaScript -->
                            </select>
                        </div>

                        <!-- Detail Pengajuan -->
                        <div id="pengajuanDetail" class="mb-4" style="display: none;">
                            <div class="alert alert-info">
                                <h6>Detail Pengajuan:</h6>
                                <p><strong>Judul:</strong> <span id="detailJudul"></span></p>
                                <p><strong>Topik:</strong> <span id="detailTopik"></span></p>
                                <p><strong>Konsentrasi:</strong> <span id="detailKonsentrasi"></span></p>
                            </div>
                        </div>

                        <!-- Pilihan Metode -->
                        <div class="method-selector">
                            <h6>Pilih Metode Rekomendasi:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="method"
                                            id="methodNaiveBayes" value="naivebayes" checked>
                                        <label class="form-check-label" for="methodNaiveBayes">
                                            <strong>Naive Bayes</strong>
                                            <br><small class="text-muted">Menggunakan machine learning untuk prediksi
                                                yang akurat</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="method"
                                            id="methodSimilarity" value="similarity">
                                        <label class="form-check-label" for="methodSimilarity">
                                            <strong>Text Similarity</strong>
                                            <br><small class="text-muted">Menggunakan kesamaan kata untuk mencocokkan
                                                keahlian</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Generate -->
                        <div class="text-center mb-4">
                            <button class="btn btn-primary btn-lg" id="generateBtn" disabled>
                                <i class="fas fa-magic"></i> Generate Rekomendasi
                            </button>
                        </div>

                        <!-- Hasil Rekomendasi -->
                        <div id="recommendationResult" class="recommendation-result">
                            <h5 class="mb-3">Rekomendasi Pembimbing:</h5>

                            <div class="row">
                                <!-- Pembimbing 1 -->
                                <div class="col-md-6">
                                    <div class="recommendation-card">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="https://via.placeholder.com/80x80" class="dosen-avatar me-3"
                                                id="avatar1">
                                            <div>
                                                <h6 class="mb-1" id="nama1">-</h6>
                                                <small class="text-muted">Pembimbing Utama</small>
                                                <div class="score-indicator mt-2">
                                                    <div class="score-bar" id="scoreBar1"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <strong>NIDN:</strong> <span id="nidn1">-</span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Keahlian:</strong>
                                            <div id="keahlian1" class="mt-1"></div>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Rumpun Ilmu:</strong> <span id="rumpun1">-</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pembimbing 2 -->
                                <div class="col-md-6">
                                    <div class="recommendation-card">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="https://via.placeholder.com/80x80" class="dosen-avatar me-3"
                                                id="avatar2">
                                            <div>
                                                <h6 class="mb-1" id="nama2">-</h6>
                                                <small class="text-muted">Pembimbing Pendamping</small>
                                                <div class="score-indicator mt-2">
                                                    <div class="score-bar" id="scoreBar2"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <strong>NIDN:</strong> <span id="nidn2">-</span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Keahlian:</strong>
                                            <div id="keahlian2" class="mt-1"></div>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Rumpun Ilmu:</strong> <span id="rumpun2">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Assign -->
                            <div class="text-center mt-4">
                                <button class="btn btn-success btn-lg" id="assignBtn">
                                    <i class="fas fa-check"></i> Tetapkan Pembimbing
                                </button>
                                <button class="btn btn-outline-secondary ms-2" id="regenerateBtn">
                                    <i class="fas fa-redo"></i> Generate Ulang
                                </button>
                            </div>
                        </div>

                        <!-- Alternative Recommendations -->
                        <div id="alternativeResult" class="recommendation-result mt-4">
                            <h6>Rekomendasi Alternatif:</h6>
                            <div id="alternativeList" class="row"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Menganalisis dan membuat rekomendasi...</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentPengajuanId = null;
        let currentRecommendations = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadPengajuanList();
            setupEventListeners();
        });

        function setupEventListeners() {
            // Pengajuan selection
            document.getElementById('pengajuanSelect').addEventListener('change', function() {
                const pengajuanId = this.value;
                if (pengajuanId) {
                    currentPengajuanId = pengajuanId;
                    showPengajuanDetail(pengajuanId);
                    document.getElementById('generateBtn').disabled = false;
                } else {
                    document.getElementById('pengajuanDetail').style.display = 'none';
                    document.getElementById('generateBtn').disabled = true;
                }
                hideRecommendationResult();
            });

            // Generate button
            document.getElementById('generateBtn').addEventListener('click', generateRecommendation);

            // Assign button
            document.getElementById('assignBtn').addEventListener('click', assignSupervisors);

            // Regenerate button
            document.getElementById('regenerateBtn').addEventListener('click', generateRecommendation);
        }

        function loadPengajuanList() {
            fetch('/admin/pengajuan-judul/datas')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const select = document.getElementById('pengajuanSelect');

                    // Clear existing options except the first one
                    while (select.options.length > 1) {
                        select.remove(1);
                    }

                    // console.log('data', data);
                    // Check if data exists and has the expected structure
                    if (data && data.data && Array.isArray(data.data)) {
                        data.data.forEach(pengajuan => {
                            const option = document.createElement('option');
                            option.value = pengajuan.id;
                            option.textContent = pengajuan.judul;
                            // Make sure these properties exist in your pengajuan object
                            option.dataset.topik = pengajuan.topik || '';
                            option.dataset.konsentrasi = pengajuan.konsentrasi || '';
                            select.appendChild(option);
                        });
                    } else {
                        console.error('Unexpected data structure:', data);
                        // Optionally show an error message to the user
                        const option = document.createElement('option');
                        option.textContent = '-- Gagal memuat data pengajuan --';
                        option.disabled = true;
                        select.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error loading pengajuan:', error);
                    // Show error in the select dropdown
                    const select = document.getElementById('pengajuanSelect');
                    const option = document.createElement('option');
                    option.textContent = '-- Error: Gagal memuat data --';
                    option.disabled = true;
                    select.appendChild(option);
                });
        }

        function showPengajuanDetail(pengajuanId) {
            const select = document.getElementById('pengajuanSelect');
            const selectedOption = select.selectedOptions[0];

            document.getElementById('detailJudul').textContent = selectedOption.textContent;
            document.getElementById('detailTopik').textContent = selectedOption.dataset.topik;
            document.getElementById('detailKonsentrasi').textContent = selectedOption.dataset.konsentrasi;

            document.getElementById('pengajuanDetail').style.display = 'block';
        }

        function generateRecommendation() {
            if (!currentPengajuanId) return;

            const method = document.querySelector('input[name="method"]:checked').value;

            // Gunakan endpoint yang sesuai
            const endpoint = method === 'naivebayes' ?
                `/admin/pembimbing/recommendation/${currentPengajuanId}` :
                `/admin/pembimbing/recommendation-similarity/${currentPengajuanId}`;

            showLoading();

            fetch(endpoint)
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        displayRecommendations(data.data);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat membuat rekomendasi');
                });
        }

        function displayRecommendations(data) {
            currentRecommendations = data;

            // Display pembimbing 1
            displayDosen(data.pembimbing1, '1');

            // Display pembimbing 2
            displayDosen(data.pembimbing2, '2');

            console.log('data', data);
            // Display alternatives if available
            if (data.all_recommendations && data.all_recommendations.length > 0) {
                displayAlternatives(data.all_recommendations);
            }

            showRecommendationResult();
        }

        function displayDosen(dosen, index) {
            console.log(dosen)
            if (!dosen) return;

            document.getElementById(`nama${index}`).textContent = dosen.nama || '-wkwk';
            document.getElementById(`nidn${index}`).textContent = dosen.nidn || '-';
            document.getElementById(`rumpun${index}`).textContent = dosen.rumpun_ilmu || '-';

            // Display keahlian badges
            const keahlianContainer = document.getElementById(`keahlian${index}`);
            keahlianContainer.innerHTML = '';
            if (dosen.keahlians && dosen.keahlians.length > 0) {
                dosen.keahlians.forEach(keahlian => {
                    const badge = document.createElement('span');
                    badge.className = 'keahlian-badge';
                    badge.textContent = keahlian;
                    keahlianContainer.appendChild(badge);
                });
            } else if (dosen.keahlian) {
                // Handle if keahlian is a string (for similarity method)
                const badge = document.createElement('span');
                badge.className = 'keahlian-badge';
                badge.textContent = dosen.keahlian;
                keahlianContainer.appendChild(badge);
            }

            // Display score bar
            const scoreBar = document.getElementById(`scoreBar${index}`);
            const score = dosen.score || 0;
            scoreBar.style.width = (score * 100) + '%';
        }

        function displayAlternatives(alternatives) {
            const container = document.getElementById('alternativeList');
            container.innerHTML = '';

            alternatives.forEach(dosen => {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3';
                col.innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">${dosen.nama}</h6>
                            <p class="card-text">
                                <small>NIDN: ${dosen.nidn}</small><br>
                                <small>Score: ${(dosen.score * 100).toFixed(1)}%</small>
                            </p>
                            <div class="score-indicator">
                                <div class="score-bar" style="width: ${(dosen.score * 100)}%"></div>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(col);
            });

            document.getElementById('alternativeResult').style.display = 'block';
        }

        function assignSupervisors() {
            if (!currentRecommendations || !currentPengajuanId) return;

            showLoading();

            const formData = {
                pembimbing1_id: currentRecommendations.pembimbing1.nidn,
                pembimbing2_id: currentRecommendations.pembimbing2.nidn
            };

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/admin/pembimbing/assign/${currentPengajuanId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        alert('Pembimbing berhasil ditetapkan!');
                        // Reset form
                        document.getElementById('pengajuanSelect').selectedIndex = 0;
                        document.getElementById('pengajuanDetail').style.display = 'none';
                        document.getElementById('generateBtn').disabled = true;
                        hideRecommendationResult();

                        currentPengajuanId = null;
                        currentRecommendations = null;
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menetapkan pembimbing');
                });
        }

        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        function showRecommendationResult() {
            document.getElementById('recommendationResult').style.display = 'block';
        }

        function hideRecommendationResult() {
            document.getElementById('recommendationResult').style.display = 'none';
            document.getElementById('alternativeResult').style.display = 'none';
        }
    </script>
</body>

</html>
