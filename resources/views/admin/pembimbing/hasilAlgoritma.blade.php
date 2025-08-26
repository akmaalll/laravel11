@extends('admin._layouts.index')


@section('content')
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

                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header">

                        <h3 class="card-title"> <i class="fas fa-info-circle"></i>Informasi Pengajuan Judul</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3">Judul</dt>
                            <dd class="col-sm-9 text-dark fw-semibold">{{ $dataPengajuan->judul }}</dd>

                            <dt class="col-sm-3">Mahasiswa</dt>
                            <dd class="col-sm-9">
                                <span
                                    class="fw-semibold">{{ $dataPengajuan->nim1 . ' - ' . $dataPengajuan->nama_mhs1 }}</span>
                                @if (!empty($dataPengajuan->nim2))
                                    , <span
                                        class="fw-semibold">{{ $dataPengajuan->nim2 . ' - ' . $dataPengajuan->nama_mhs2 }}</span>
                                @endif
                            </dd>

                            <dt class="col-sm-3">Status</dt>
                            <dd class="col-sm-9">
                                <span
                                    class="text-white badge 
                                        @if ($dataPengajuan->status == 'diajukan') bg-info
                                        @elseif($dataPengajuan->status == 'diterima') bg-success
                                        @else bg-secondary @endif
                                    ">
                                    {{ ucfirst($dataPengajuan->status) }}
                                </span>
                            </dd>

                            <dt class="col-sm-3">Topik / Keahlian</dt>
                            <dd class="col-sm-9 text-muted">{{ $dataPengajuan->nama_keahlian }}</dd>
                        </dl>
                    </div>
                </div>

                <div class="row g-5">
                    <div class="col-12 col-xl-4">
                        <!-- STEP SUMMARY / PROGRESS -->
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Ringkasan Proses</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-5">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold">Progress</span>
                                        <span class="badge bg-success">Selesai</span>
                                    </div>
                                    <div class="progress" style="height:10px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="list-group" id="nb-stepper">
                                    <button type="button"
                                        class="list-group-item list-group-item-action d-flex align-items-start stepper-item current"
                                        data-step="1">
                                        <div
                                            class="me-3 w-36px h-36px d-flex align-items-center justify-content-center rounded-circle bg-light">
                                            1</div>
                                        <div>
                                            <div class="fw-bold">Filter Data</div>
                                            <div class="small text-muted">Keahlian • Penelitian • Riwayat</div>
                                        </div>
                                    </button>

                                    <button type="button"
                                        class="list-group-item list-group-item-action d-flex align-items-start stepper-item"
                                        data-step="2">
                                        <div
                                            class="me-3 w-36px h-36px d-flex align-items-center justify-content-center rounded-circle bg-light">
                                            2</div>
                                        <div>
                                            <div class="fw-bold">Bangun Data Latih</div>
                                            <div class="small text-muted">Simpan ke naive_bayes_training_data</div>
                                        </div>
                                    </button>

                                    <button type="button"
                                        class="list-group-item list-group-item-action d-flex align-items-start stepper-item"
                                        data-step="3">
                                        <div
                                            class="me-3 w-36px h-36px d-flex align-items-center justify-content-center rounded-circle bg-light">
                                            3</div>
                                        <div>
                                            <div class="fw-bold">Prior P(Status)</div>
                                            <div class="small text-muted">psat: Disarankan & Rekomendasi</div>
                                        </div>
                                    </button>

                                    <button type="button"
                                        class="list-group-item list-group-item-action d-flex align-items-start stepper-item"
                                        data-step="4">
                                        <div
                                            class="me-3 w-36px h-36px d-flex align-items-center justify-content-center rounded-circle bg-light">
                                            4</div>
                                        <div>
                                            <div class="fw-bold">Likelihood</div>
                                            <div class="small text-muted">Probabilitas & Perhitungan Skor</div>
                                        </div>
                                    </button>

                                    <button type="button"
                                        class="list-group-item list-group-item-action d-flex align-items-start stepper-item"
                                        data-step="5">
                                        <div
                                            class="me-3 w-36px h-36px d-flex align-items-center justify-content-center rounded-circle bg-light">
                                            5</div>
                                        <div>
                                            <div class="fw-bold">Hasil & Assign</div>
                                            <div class="small text-muted">Pilih Pembimbing</div>
                                        </div>
                                    </button>
                                </div>

                                <div class="separator my-5"></div>

                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex justify-content-between"><span>Jumlah Data Latih</span><span
                                            class="fw-bold">{{ count($dataLatih ?? []) }}</span></div>
                                    <div class="d-flex justify-content-between"><span>Variabel</span><span
                                            class="fw-bold">Keahlian • Penelitian • Riwayat</span></div>
                                    <div class="d-flex justify-content-between"><span>Kategori Status</span><span
                                            class="fw-bold">Disarankan, Rekomendasi</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-8">
                        <!-- TIMELINE / CONTENT -->
                        <div class="card shadow-sm">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title mb-0">Timeline Proses Algoritma</h3>
                                <div>
                                    <button class="btn btn-sm btn-light" id="expandAll">Expand All</button>
                                    <button class="btn btn-sm btn-light" id="collapseAll">Collapse All</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="nb-accordion">
                                    <!-- STEP 1 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true">
                                                <span class="badge bg-light text-dark me-3">Step 1</span> Filter Data
                                                (Keahlian, Penelitian, Riwayat)
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            data-bs-parent="#nb-accordion">
                                            <div class="accordion-body">
                                                <p class="text-gray-700">Mengambil dosen berdasarkan <em>id_keahlian</em>
                                                    judul yang diajukan, menyatukan riwayat pembimbing P1 & P2.</p>
                                                <div class="alert alert-primary">
                                                    <div>
                                                        <strong>Output ringkas:</strong> kandidat dosen dengan hitungan
                                                        <code>jumlah_keahlian</code>, <code>jumlah_penelitian</code>,
                                                        <code>jumlah_riwayat</code>.
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-row-dashed align-middle">
                                                        <thead>
                                                            <tr>
                                                                <th>NIDN</th>
                                                                <th>Nama</th>
                                                                <th>Label Keahlian</th>
                                                                <th>Label Penelitian</th>
                                                                <th>Label Riwayat</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach (($datanassami ?? collect())->take(10) as $r)
                                                                <tr>
                                                                    <td>{{ $r->nidn }}</td>
                                                                    <td>{{ $r->nama }}</td>
                                                                    <td>{{ $r->label_keahlian }}</td>
                                                                    <td>{{ $r->label_penelitian }}</td>
                                                                    <td>{{ $r->label_riwayat }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- STEP 2 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                                <span class="badge bg-light text-dark me-3">Step 2</span> Bangun Data Latih
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            data-bs-parent="#nb-accordion">
                                            <div class="accordion-body">
                                                <p class="text-gray-700 mb-4">Menyimpan rekap kandidat ke tabel
                                                    <code>naive_bayes_training_data</code>.
                                                </p>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>NIDN</th>
                                                                <th>Nama</th>
                                                                <th>Keahlian</th>
                                                                <th>Penelitian</th>
                                                                <th>Riwayat</th>
                                                                <th>Total (r)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($dataLatih ?? [] as $row)
                                                                <tr>
                                                                    <td>{{ $row->nidn }}</td>
                                                                    <td>{{ $row->nama }}</td>
                                                                    <td>{{ $row->jumlah_keahlian }}</td>
                                                                    <td>{{ $row->jumlah_penelitian }}</td>
                                                                    <td>{{ $row->jumlah_riwayat }}</td>
                                                                    <td>{{ $row->rekomendasi }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- STEP 3 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                                <span class="badge bg-light text-dark me-3">Step 3</span> Prior P(Status)
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            data-bs-parent="#nb-accordion">
                                            <div class="accordion-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="card bg-light-success border-0">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="fw-semibold">P(Disarankan)</span>
                                                                    <span
                                                                        class="fs-5 fw-bold">{{ number_format($psat[0] ?? 0, 4) }}</span>
                                                                </div>
                                                                <div class="text-muted small">= jumlah Disarankan / total
                                                                    data latih</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card bg-light-primary border-0">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="fw-semibold">P(Rekomendasi)</span>
                                                                    <span
                                                                        class="fs-5 fw-bold">{{ number_format($psat[1] ?? 0, 4) }}</span>
                                                                </div>
                                                                <div class="text-muted small">= jumlah Rekomendasi / total
                                                                    data latih</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- STEP 4 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFour">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                                <span class="badge bg-light text-dark me-3">Step 4</span> Likelihood & Skor
                                                Per Dosen
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse"
                                            data-bs-parent="#nb-accordion">
                                            <div class="accordion-body">
                                                <h6 class="mb-3">Probabilitas Tiap Nilai</h6>
                                                <div class="table-responsive mb-6">
                                                    <table class="table table-hover align-middle">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Info</th>
                                                                <th>Nilai</th>
                                                                <th>Disarankan</th>
                                                                <th>Rekomendasi</th>
                                                                <th>Perhitungan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($results ?? [] as $row)
                                                                <tr>
                                                                    <td>{{ $row['info'] }}</td>
                                                                    <td>{{ $row['nilai'] }}</td>
                                                                    <td>{{ number_format($row['disarankan'], 5) }}</td>
                                                                    <td>{{ number_format($row['rekomendasi'], 5) }}</td>
                                                                    <td>
                                                                        <div class="text-muted small">
                                                                            {{ $row['perhitungan_disarankan'] }}</div>
                                                                        <div class="text-muted small">
                                                                            {{ $row['perhitungan_rekomendasi'] }}</div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <h6 class="mb-3">Top Kandidat per Kelompok</h6>
                                                <div class="row g-5">
                                                    <div class="col-md-6">
                                                        <div class="card border-dashed">
                                                            <div class="card-header py-3">
                                                                <h6 class="mb-0">Lektor Rekomendasi</h6>
                                                            </div>
                                                            <div class="card-body p-0">
                                                                <ul class="list-group list-group-flush">
                                                                    @forelse($sortRekomendasiLektor ?? [] as $x)
                                                                        @php
                                                                            $s = floatval($x['skor'] ?? 0);
                                                                            $badge =
                                                                                $s >= 0.8
                                                                                    ? 'bg-success'
                                                                                    : ($s >= 0.5
                                                                                        ? 'bg-warning text-dark'
                                                                                        : 'bg-secondary');
                                                                        @endphp
                                                                        <li
                                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                                            <div>
                                                                                <div class="fw-semibold">
                                                                                    {{ $x['nama'] }}</div>
                                                                                <div class="text-muted small">NIDN:
                                                                                    {{ $x['nidn'] }}</div>
                                                                                <div class="mt-1">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-link p-0 me-2 btn-show-candidate"
                                                                                        data-nidn="{{ $x['nidn'] }}"
                                                                                        data-name="{{ $x['nama'] }}"
                                                                                        data-score="{{ $x['skor'] }}"
                                                                                        data-formula="{{ $x['perhitungan_label'] ?? '-' }}">Lihat
                                                                                        detail</button>
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-link p-0"
                                                                                        onclick="copyText(`{{ $x['perhitungan_label'] ?? '-' }}`)">Salin
                                                                                        rumus</button>
                                                                                </div>
                                                                            </div>
                                                                            <span
                                                                                class="badge {{ $badge }}">{{ number_format($s, 4) }}</span>
                                                                        </li>
                                                                    @empty
                                                                        <li class="list-group-item">Tidak ada data</li>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="card border-dashed">
                                                            <div class="card-header py-3">
                                                                <h6 class="mb-0">Lektor Disarankan</h6>
                                                            </div>
                                                            <div class="card-body p-0">
                                                                <ul class="list-group list-group-flush">
                                                                    @forelse($sortDisarankanLektor ?? [] as $x)
                                                                        @php
                                                                            $s = floatval($x['skor'] ?? 0);
                                                                            $badge =
                                                                                $s >= 0.8
                                                                                    ? 'bg-success'
                                                                                    : ($s >= 0.5
                                                                                        ? 'bg-warning text-dark'
                                                                                        : 'bg-secondary');
                                                                        @endphp
                                                                        <li
                                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                                            <div>
                                                                                <div class="fw-semibold">
                                                                                    {{ $x['nama'] }}</div>
                                                                                <div class="text-muted small">NIDN:
                                                                                    {{ $x['nidn'] }}</div>
                                                                                <div class="mt-1">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-link p-0 me-2 btn-show-candidate"
                                                                                        data-nidn="{{ $x['nidn'] }}"
                                                                                        data-name="{{ $x['nama'] }}"
                                                                                        data-score="{{ $x['skor'] }}"
                                                                                        data-formula="{{ $x['perhitungan_label'] ?? '-' }}">Lihat
                                                                                        detail</button>
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-link p-0"
                                                                                        onclick="copyText(`{{ $x['perhitungan_label'] ?? '-' }}`)">Salin
                                                                                        rumus</button>
                                                                                </div>
                                                                            </div>
                                                                            <span
                                                                                class="badge {{ $badge }}">{{ number_format($s, 4) }}</span>
                                                                        </li>
                                                                    @empty
                                                                        <li class="list-group-item">Tidak ada data</li>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="card border-dashed">
                                                            <div class="card-header py-3">
                                                                <h6 class="mb-0">Ahli Rekomendasi</h6>
                                                            </div>
                                                            <div class="card-body p-0">
                                                                <ul class="list-group list-group-flush">
                                                                    @forelse($sortRekomendasiAhli ?? [] as $x)
                                                                        @php
                                                                            $s = floatval($x['skor'] ?? 0);
                                                                            $badge =
                                                                                $s >= 0.8
                                                                                    ? 'bg-success'
                                                                                    : ($s >= 0.5
                                                                                        ? 'bg-warning text-dark'
                                                                                        : 'bg-secondary');
                                                                        @endphp
                                                                        <li
                                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                                            <div>
                                                                                <div class="fw-semibold">
                                                                                    {{ $x['nama'] }}</div>
                                                                                <div class="text-muted small">NIDN:
                                                                                    {{ $x['nidn'] }}</div>
                                                                                <div class="mt-1">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-link p-0 me-2 btn-show-candidate"
                                                                                        data-nidn="{{ $x['nidn'] }}"
                                                                                        data-name="{{ $x['nama'] }}"
                                                                                        data-score="{{ $x['skor'] }}"
                                                                                        data-formula="{{ $x['perhitungan_label'] ?? '-' }}">Lihat
                                                                                        detail</button>
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-link p-0"
                                                                                        onclick="copyText(`{{ $x['perhitungan_label'] ?? '-' }}`)">Salin
                                                                                        rumus</button>
                                                                                </div>
                                                                            </div>
                                                                            <span
                                                                                class="badge {{ $badge }}">{{ number_format($s, 4) }}</span>
                                                                        </li>
                                                                    @empty
                                                                        <li class="list-group-item">Tidak ada data</li>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="card border-dashed">
                                                            <div class="card-header py-3">
                                                                <h6 class="mb-0">Ahli Disarankan</h6>
                                                            </div>
                                                            <div class="card-body p-0">
                                                                <ul class="list-group list-group-flush">
                                                                    @forelse($sortDisarankanAhli ?? [] as $x)
                                                                        @php
                                                                            $s = floatval($x['skor'] ?? 0);
                                                                            $badge =
                                                                                $s >= 0.8
                                                                                    ? 'bg-success'
                                                                                    : ($s >= 0.5
                                                                                        ? 'bg-warning text-dark'
                                                                                        : 'bg-secondary');
                                                                        @endphp
                                                                        <li
                                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                                            <div>
                                                                                <div class="fw-semibold">
                                                                                    {{ $x['nama'] }}</div>
                                                                                <div class="text-muted small">NIDN:
                                                                                    {{ $x['nidn'] }}</div>
                                                                                <div class="mt-1">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-link p-0 me-2 btn-show-candidate"
                                                                                        data-nidn="{{ $x['nidn'] }}"
                                                                                        data-name="{{ $x['nama'] }}"
                                                                                        data-score="{{ $x['skor'] }}"
                                                                                        data-formula="{{ $x['perhitungan_label'] ?? '-' }}">Lihat
                                                                                        detail</button>
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-link p-0"
                                                                                        onclick="copyText(`{{ $x['perhitungan_label'] ?? '-' }}`)">Salin
                                                                                        rumus</button>
                                                                                </div>
                                                                            </div>
                                                                            <span
                                                                                class="badge {{ $badge }}">{{ number_format($s, 4) }}</span>
                                                                        </li>
                                                                    @empty
                                                                        <li class="list-group-item">Tidak ada data</li>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- STEP 5 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFive">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                                <span class="badge bg-light text-dark me-3">Step 5</span> Hasil & Penugasan
                                                Pembimbing
                                            </button>
                                        </h2>
                                        <div id="collapseFive" class="accordion-collapse collapse"
                                            data-bs-parent="#nb-accordion">
                                            <div class="accordion-body">
                                                <form action="" method="POST" id="formAssign">
                                                    @csrf

                                                    <input type="hidden" name="judul_id"
                                                        value="{{ $dataPengajuan->id }}">

                                                    <div class="row g-4">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Pembimbing 1</label>
                                                            <select name="pembimbing1" id="pembimbing1"
                                                                class="form-select" required>
                                                                <option value="">-- Pilih Pembimbing 1 --</option>
                                                                @foreach ($sortRekomendasiLektor ?? [] as $item)
                                                                    <option value="{{ $item['nidn'] }}">
                                                                        {{ $item['nama'] }} - NIDN: {{ $item['nidn'] }}
                                                                        (Skor: {{ $item['skor'] }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="form-text">Wajib dari kelompok <strong>Lektor
                                                                    Rekomendasi</strong>.</div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Pembimbing 2</label>
                                                            <select name="pembimbing2" id="pembimbing2"
                                                                class="form-select" required>
                                                                <option value="">-- Pilih Pembimbing 2 --</option>
                                                                <optgroup label="Lektor Disarankan">
                                                                    @foreach ($sortDisarankanLektor ?? [] as $item)
                                                                        <option value="{{ $item['nidn'] }}">
                                                                            {{ $item['nama'] }} - NIDN:
                                                                            {{ $item['nidn'] }} (Skor:
                                                                            {{ $item['skor'] }})
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="Ahli Rekomendasi">
                                                                    @foreach ($sortRekomendasiAhli ?? [] as $item)
                                                                        <option value="{{ $item['nidn'] }}">
                                                                            {{ $item['nama'] }} - NIDN:
                                                                            {{ $item['nidn'] }} (Skor:
                                                                            {{ $item['skor'] }})
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="Ahli Disarankan">
                                                                    @foreach ($sortDisarankanAhli ?? [] as $item)
                                                                        <option value="{{ $item['nidn'] }}">
                                                                            {{ $item['nama'] }} - NIDN:
                                                                            {{ $item['nidn'] }} (Skor:
                                                                            {{ $item['skor'] }})
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                            <div class="form-text">Boleh dari <strong>Lektor
                                                                    Disarankan</strong> atau <strong>Ahli
                                                                    (Rekomendasi/Disarankan)</strong>.</div>
                                                        </div>
                                                    </div>

                                                    <div class="alert alert-warning d-flex align-items-center gap-3 mt-4"
                                                        id="alertDuplikat" style="display:none;">
                                                        <i class="ki-duotone ki-information-5 fs-2"></i>
                                                        <div>Pembimbing 1 dan Pembimbing 2 tidak boleh sama.</div>
                                                    </div>

                                                    <div class="mt-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="ki-duotone ki-save-2"></i> Simpan Penugasan
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Candidate Detail Modal -->
    <div class="modal fade" id="candidateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Kandidat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8" id="modalName">-</dd>

                        <dt class="col-sm-4">NIDN</dt>
                        <dd class="col-sm-8" id="modalNidn">-</dd>

                        <dt class="col-sm-4">Skor</dt>
                        <dd class="col-sm-8" id="modalScore">-</dd>

                        <dt class="col-sm-4">Perhitungan</dt>
                        <dd class="col-sm-8" id="modalFormula">
                            <pre class="small mb-0">-</pre>
                        </dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('jsScript')
    <script>
        // Robust stepper -> show related accordion panel
        (function() {
            const stepperItems = document.querySelectorAll('#nb-stepper .stepper-item');
            const targets = ['#collapseOne', '#collapseTwo', '#collapseThree', '#collapseFour', '#collapseFive'];

            stepperItems.forEach(item => {
                item.addEventListener('click', function() {
                    const step = parseInt(this.getAttribute('data-step')) || 1;
                    // toggle active class
                    stepperItems.forEach(i => i.classList.remove('current'));
                    this.classList.add('current');

                    // collapse all
                    targets.forEach(t => {
                        const el = document.querySelector(t);
                        if (el) {
                            const inst = bootstrap.Collapse.getOrCreateInstance(el, {
                                toggle: false
                            });
                            inst.hide();
                        }
                    });

                    // show selected
                    const targetEl = document.querySelector(targets[step - 1]);
                    if (targetEl) bootstrap.Collapse.getOrCreateInstance(targetEl, {
                        toggle: false
                    }).show();
                });
            });

            // Expand/Collapse all
            document.getElementById('expandAll')?.addEventListener('click', () => {
                document.querySelectorAll('#nb-accordion .accordion-collapse').forEach(x => bootstrap.Collapse
                    .getOrCreateInstance(x, {
                        toggle: false
                    }).show());
            })
            document.getElementById('collapseAll')?.addEventListener('click', () => {
                document.querySelectorAll('#nb-accordion .accordion-collapse').forEach(x => bootstrap.Collapse
                    .getOrCreateInstance(x, {
                        toggle: false
                    }).hide());
            })
        })();

        // Copy helper
        function copyText(txt) {
            try {
                navigator.clipboard.writeText(txt || '');
                if (window.toastr) toastr.success('Rumus disalin ke clipboard');
                else {
                    const el = document.createElement('div');
                    el.innerText = 'Rumus disalin';
                    document.body.appendChild(el);
                    setTimeout(() => el.remove(), 1200);
                }
            } catch (e) {
                alert('Gagal menyalin');
            }
        }

        // Modal detail
        document.querySelectorAll('.btn-show-candidate').forEach(btn => {
            btn.addEventListener('click', function() {
                const name = this.dataset.name || '-';
                const nidn = this.dataset.nidn || '-';
                const score = this.dataset.score || '-';
                const formula = this.dataset.formula || '-';

                document.getElementById('modalName').innerText = name;
                document.getElementById('modalNidn').innerText = nidn;
                document.getElementById('modalScore').innerText = score;
                document.getElementById('modalFormula').innerText = formula;

                const modalEl = document.getElementById('candidateModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            })
        });

        // validation pembimbing -> tidak boleh sama + disable opsi sama di p2
        (function() {
            const p1 = document.getElementById('pembimbing1');
            const p2 = document.getElementById('pembimbing2');
            const alertDuplikat = document.getElementById('alertDuplikat');
            const form = document.getElementById('formAssign');

            function syncDisableOptions() {
                if (!p1 || !p2) return;
                const chosen = p1.value;
                p2.querySelectorAll('option').forEach(opt => {
                    if (opt.value && opt.value === chosen) opt.disabled = true;
                    else opt.disabled = false;
                });
                // refresh select2 UI if used
                if (window.jQuery && jQuery(p2).data('select2')) jQuery(p2).trigger('change.select2');
            }

            function validateDistinct() {
                if (!p1 || !p2) return true;
                const same = p1.value && p2.value && p1.value === p2.value;
                alertDuplikat.style.display = same ? 'flex' : 'none';
                return !same;
            }

            p1?.addEventListener('change', () => {
                syncDisableOptions();
                validateDistinct();
            });
            p2?.addEventListener('change', validateDistinct);
            form?.addEventListener('submit', function(e) {
                if (!validateDistinct()) e.preventDefault();
            });

            // initial run
            syncDisableOptions();
        })();

        // Optional: init Select2 if available (improves UX)
        (function() {
            if (window.jQuery && jQuery.fn && jQuery.fn.select2) {
                jQuery('#pembimbing1').select2({
                    placeholder: '-- Pilih Pembimbing 1 --',
                    width: '100%',
                    dropdownParent: jQuery('#formAssign')
                });
                jQuery('#pembimbing2').select2({
                    placeholder: '-- Pilih Pembimbing 2 --',
                    width: '100%',
                    dropdownParent: jQuery('#formAssign')
                });
            }
        })();

        document.getElementById('formAssign').addEventListener('submit', function(e) {
            e.preventDefault();

            let pembimbing1 = document.getElementById('pembimbing1').value;
            let pembimbing2 = document.getElementById('pembimbing2').value;
            let judulId = document.querySelector('[name="judul_id"]').value;

            // Cek duplikat
            if (pembimbing1 === pembimbing2) {
                document.getElementById('alertDuplikat').style.display = 'flex';
                return;
            } else {
                document.getElementById('alertDuplikat').style.display = 'none';
            }

            $.ajax({
                url: "{{ route('pembimbing.assign') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    judul_id: judulId,
                    pembimbing1: pembimbing1,
                    pembimbing2: pembimbing2,
                    status: 'assigned'
                },
                success: function(res) {
                    console.log(res);
                    toastr.success(res.message || "Penugasan berhasil disimpan!");
                    setTimeout(() => window.location.replace(
                        "{{ route('judul.index') }}"
                    ), 1500);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    let res = JSON.parse(xhr.responseText);
                    if (res.errors) {
                        Object.values(res.errors).forEach(msg => toastr.error(msg));
                    } else {
                        toastr.error("Terjadi kesalahan saat menyimpan.");
                    }
                }

            });
        });
    </script>
@endpush
