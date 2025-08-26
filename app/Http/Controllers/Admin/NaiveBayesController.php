<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Phpml\Classification\NaiveBayes;

class NaiveBayesController extends Controller
{
    protected $keahlian_dosen, $riwayat_bimbingan, $penelitian_dosen;

    public function __construct()
    {
        $this->keahlian_dosen = DB::table('KeahlianDosenView')->whereNotNull('nidn')->get();
        $this->riwayat_bimbingan = DB::table('mst_judul')->where('status', 'diterima')->get();
        $this->penelitian_dosen = DB::table('PenelitianDosenView')->get();
    }

        public function index()
        {
            try {
                $title = 'Assignment Pembimbing'; // Add missing title variable
                return view('admin.pembimbing.assignment', compact('title'));
            } catch (\Exception $e) {
                return view('errors.message', ['message' => $e->getMessage()]);
            }
        }

    // ====== HELPER: TRAIN & PREDICT NAIVE BAYES (BINER + LAPLACE) ======
    private function nbTrainBinary(array $samples, array $labels, array $classes = ['Layak', 'Tidak Layak'], float $alpha = 1.0)
    {
        $n = count($samples);
        $kfeat = count($samples[0] ?? [0, 0, 0]);
        $countsClass = array_fill_keys($classes, 0);
        $sumFeat1PerClass = []; // [class][featIndex] = jumlah xi=1 pada class tsb

        foreach ($classes as $c) {
            $sumFeat1PerClass[$c] = array_fill(0, $kfeat, 0);
        }

        // hitung prior & jumlah xi=1 per class
        for ($i = 0; $i < $n; $i++) {
            $c = $labels[$i];
            $countsClass[$c]++;
            for ($f = 0; $f < $kfeat; $f++) {
                if ((int)$samples[$i][$f] === 1) {
                    $sumFeat1PerClass[$c][$f]++;
                }
            }
        }

        // prior P(class)
        $prior = [];
        foreach ($classes as $c) {
            $prior[$c] = ($countsClass[$c] + $alpha) / ($n + $alpha * count($classes));
        }

        // likelihood P(xi=1 | class) dg Laplace: (count1 + alpha) / (countClass + 2*alpha)  // karena biner
        $likelihood1 = []; // [class][featIndex]
        foreach ($classes as $c) {
            $likelihood1[$c] = [];
            for ($f = 0; $f < $kfeat; $f++) {
                $likelihood1[$c][$f] = ($sumFeat1PerClass[$c][$f] + $alpha) / ($countsClass[$c] + 2.0 * $alpha);
            }
        }

        return [
            'classes' => $classes,
            'prior' => $prior,
            'likelihood1' => $likelihood1,
        ];
    }

    /**
     * $x: satu sampel fitur biner, mis: [keahlian, penelitian, judul]
     * Return: probs [class => P(class|x)] ternormalisasi
     */
    private function nbPredictProbaBinary(array $model, array $x): array
    {
        $classes = $model['classes'];
        $prior = $model['prior'];
        $lik1 = $model['likelihood1'];

        $unnorm = [];
        foreach ($classes as $c) {
            // log-space biar stabil (boleh juga langsung perkalian kalau 3 fitur saja)
            $logp = log($prior[$c]);
            for ($f = 0; $f < count($x); $f++) {
                $p1 = $lik1[$c][$f];       // P(xf=1|c)
                $p0 = 1.0 - $p1;           // P(xf=0|c)
                $logp += log($x[$f] ? $p1 : $p0);
            }
            $unnorm[$c] = $logp;
        }

        // convert log-prob ke prob & normalisasi
        $max = max($unnorm);
        $sum = 0.0;
        $tmp = [];
        foreach ($unnorm as $c => $lv) {
            $v = exp($lv - $max);
            $tmp[$c] = $v;
            $sum += $v;
        }
        $probs = [];
        foreach ($tmp as $c => $v) {
            $probs[$c] = $v / ($sum ?: 1.0);
        }
        return $probs;
    }

    private function loadTrainingData(): array
    {
        $rows = DB::table('naive_bayes_training_data')->select('keahlian', 'penelitian', 'judul', 'label')->get();
        $samples = [];
        $labels  = [];
        foreach ($rows as $r) {
            $samples[] = [(int)$r->keahlian, (int)$r->penelitian, (int)$r->judul];
            $labels[]  = $r->label; // 'Layak' / 'Tidak Layak'
        }
        
        return [$samples, $labels];
    }

    public function getJudulPengajuan($id)
    {
        // $dataPengajuan = DB::table('mst_judul')->where('id', $id)->first();
        $dataPengajuan = DB::table('mst_judul')
            ->join('mst_keahlian', 'mst_judul.id_keahlian', '=', 'mst_keahlian.id')
            ->where('mst_judul.id', $id)
            ->select('mst_judul.*', 'mst_keahlian.nama as nama_keahlian')
            ->first();


        // Ambil dosen sesuai keahlian dengan join ke mst_dosen untuk jabatan_fungsional
        $hasilFilterKeahlian = DB::table('keahliandosenview as kdv')
            ->select('kdv.nidn', 'kdv.nama', 'md.jabatan_fungsional', DB::raw("COUNT(kdv.nidn) as jumlah_dosen"))
            ->leftJoin('mst_dosen as md', 'md.nidn', '=', 'kdv.nidn')
            ->where('kdv.id_keahlian', '=', $dataPengajuan->id_keahlian)
            ->whereNotNull('kdv.nidn')
            ->groupBy('kdv.nidn', 'kdv.nama', 'md.jabatan_fungsional')
            ->get();

        // Ambil dosen sesuai penelitian dengan join ke mst_dosen untuk jabatan_fungsional
        $hasilFilterPenelitian = DB::table('penelitiandosenview as pdv')
            ->select('pdv.nidn', 'pdv.nama', 'md.jabatan_fungsional', DB::raw("COUNT(pdv.nidn) as jumlah_dosen"))
            ->leftJoin('mst_dosen as md', 'md.nidn', '=', 'pdv.nidn')
            ->where('pdv.id_keahlian', '=', $dataPengajuan->id_keahlian)
            ->whereNotNull('pdv.nidn')
            ->groupBy('pdv.nidn', 'pdv.nama', 'md.jabatan_fungsional')
            ->get();

        // Ambil dosen dari judul yang diterima dengan join ke mst_dosen untuk jabatan_fungsional
        $hasilFilterJudul = DB::table('mst_judul')
            ->select(
                'mst_judul.judul',
                'mst_judul.id_keahlian',
                'mst_keahlian.nama as nama_keahlian',
                'mst_judul.nidn1',
                'd1.nama as nama_dosen1',
                'd1.jabatan_fungsional as jabatan_dosen1',
                'mst_judul.nidn2',
                'd2.nama as nama_dosen2',
                'd2.jabatan_fungsional as jabatan_dosen2'
            )
            ->leftJoin('mst_dosen as d1', 'd1.nidn', '=', 'mst_judul.nidn1')
            ->leftJoin('mst_dosen as d2', 'd2.nidn', '=', 'mst_judul.nidn2')
            ->leftJoin('mst_keahlian', 'mst_keahlian.id', '=', 'mst_judul.id_keahlian')
            ->where('mst_judul.id_keahlian', '=', $dataPengajuan->id_keahlian)
            ->where('mst_judul.status', '=', 'diterima')
            ->get();

        // List dosen gabungan
        $dosenList = [];

        // Helper function untuk bikin default struktur
        $setDefault = function ($nidn, $nama = null, $jabatan = null) use (&$dosenList) {
            if (!isset($dosenList[$nidn])) {
                $dosenList[$nidn] = [
                    'nidn' => $nidn,
                    'nama' => $nama,
                    'jabatan_fungsional' => $jabatan,
                    'keahlian' => 0,
                    'penelitian' => 0,
                    'judul' => 0,
                ];
            } else {
                // Update nama dan jabatan kalau sebelumnya null
                if ($nama && empty($dosenList[$nidn]['nama'])) {
                    $dosenList[$nidn]['nama'] = $nama;
                }
                if ($jabatan && empty($dosenList[$nidn]['jabatan_fungsional'])) {
                    $dosenList[$nidn]['jabatan_fungsional'] = $jabatan;
                }
            }
        };

        // Tambahkan dari hasil keahlian
        foreach ($hasilFilterKeahlian as $row) {
            $setDefault($row->nidn, $row->nama, $row->jabatan_fungsional);
            $dosenList[$row->nidn]['keahlian'] = 1;
        }

        // Tambahkan dari hasil penelitian
        foreach ($hasilFilterPenelitian as $row) {
            $setDefault($row->nidn, $row->nama, $row->jabatan_fungsional);
            $dosenList[$row->nidn]['penelitian'] = 1;
        }

        // Tambahkan dari hasil judul
        foreach ($hasilFilterJudul as $row) {
            if ($row->nidn1) {
                $setDefault($row->nidn1, $row->nama_dosen1, $row->jabatan_dosen1);
                $dosenList[$row->nidn1]['judul'] = 1;
            }
            if ($row->nidn2) {
                $setDefault($row->nidn2, $row->nama_dosen2, $row->jabatan_dosen2);
                $dosenList[$row->nidn2]['judul'] = 1;
            }
        }

        // === TRAIN model dari DB (atau fallback) ===
        [$samples, $labels] = $this->loadTrainingData();
        $model = $this->nbTrainBinary($samples, $labels, ['Layak', 'Tidak Layak'], 1.0);

        // === PREDIKSI PROBABILITAS + RANKING ===
        $hasilPrediksi = [];
        foreach ($dosenList as $d) {
            $fitur = [(int)$d['keahlian'], (int)$d['penelitian'], (int)$d['judul']];
            $probs = $this->nbPredictProbaBinary($model, $fitur);

            // Validasi jabatan fungsional untuk kelayakan
            $jabatan = strtolower($d['jabatan_fungsional'] ?? '');
            $isValidJabatan = str_contains($jabatan, 'lektor') || str_contains($jabatan, 'ahli');

            // Override prediksi jika jabatan tidak memenuhi syarat
            $finalPrediksi = $probs['Layak'] > $probs['Tidak Layak'] ? 'Layak' : 'Tidak Layak';
            if (!$isValidJabatan && $finalPrediksi === 'Layak') {
                $finalPrediksi = 'Tidak Layak';
                // Adjust probabilities
                $probs['Layak'] = 0.0;
                $probs['Tidak Layak'] = 1.0;
            }

            $hasilPrediksi[] = [
                'nidn'                => $d['nidn'],
                'nama'                => $d['nama'],
                'jabatan_fungsional'  => $d['jabatan_fungsional'] ?? 'Tidak Diketahui',
                'fitur'               => ['keahlian' => $fitur[0], 'penelitian' => $fitur[1], 'judul' => $fitur[2]],
                'probs'               => $probs,
                'prediksi'            => $finalPrediksi,
                'skor'                => round($probs['Layak'] ?? 0, 6),
                'can_be_pembimbing1'  => str_contains($jabatan, 'lektor'),
                'can_be_pembimbing2'  => str_contains($jabatan, 'lektor') || str_contains($jabatan, 'ahli')
            ];
        }

        // urutkan dari P(Layak|fitur) tertinggi
        usort($hasilPrediksi, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return response()->json([
            'dataPengajuan' => $dataPengajuan,
            'rekomendasi'   => $hasilPrediksi
        ]);
    }

    /**
     * Save assignment pembimbing
     */
    public function saveAssignment(Request $request)
    {
        try {
            $request->validate([
                'pengajuan_id' => 'required|exists:mst_judul,id',
                'pembimbing1' => 'required|exists:mst_dosen,nidn',
                'pembimbing2' => 'required|exists:mst_dosen,nidn|different:pembimbing1'
            ]);

            // Validate jabatan fungsional
            $pembimbing1 = DB::table('mst_dosen')->where('nidn', $request->pembimbing1)->first();
            $pembimbing2 = DB::table('mst_dosen')->where('nidn', $request->pembimbing2)->first();

            $jabatan1 = strtolower($pembimbing1->jabatan_fungsional ?? '');
            $jabatan2 = strtolower($pembimbing2->jabatan_fungsional ?? '');

            // Validate pembimbing 1 (harus lektor)
            if (!str_contains($jabatan1, 'lektor')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembimbing 1 harus memiliki jabatan Lektor!'
                ], 400);
            }

            // Validate pembimbing 2 (lektor atau ahli)
            if (!str_contains($jabatan2, 'lektor') && !str_contains($jabatan2, 'ahli')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembimbing 2 harus memiliki jabatan Lektor atau Ahli!'
                ], 400);
            }

            // Update assignment
            DB::table('mst_judul')
                ->where('id', $request->pengajuan_id)
                ->update([
                    'nidn1' => $request->pembimbing1,
                    'nidn2' => $request->pembimbing2,
                    'status' => 'diterima', // atau status yang sesuai
                    'updated_at' => now()
                ]);

            // === Tambahkan ke data training ===
            $dataPengajuan = DB::table('mst_judul')
                ->where('id', $request->pengajuan_id)
                ->first();

            // ambil fitur biner: apakah sesuai keahlian/penelitian/judul?
            $fitur = [
                'keahlian'   => DB::table('keahliandosenview')
                    ->where('nidn', $request->pembimbing1)
                    ->where('id_keahlian', $dataPengajuan->id_keahlian)
                    ->exists() ? 1 : 0,
                'penelitian' => DB::table('penelitiandosenview')
                    ->where('nidn', $request->pembimbing1)
                    ->where('id_keahlian', $dataPengajuan->id_keahlian)
                    ->exists() ? 1 : 0,
                'judul'      => DB::table('mst_judul')
                    ->where(function ($q) use ($request) {
                        $q->where('nidn1', $request->pembimbing1)
                            ->orWhere('nidn2', $request->pembimbing1);
                    })
                    ->where('status', 'diterima')
                    ->where('id_keahlian', $dataPengajuan->id_keahlian)
                    ->exists() ? 1 : 0,
            ];

            // simpan data training
            DB::table('naive_bayes_training_data')->insert([
                'keahlian'   => $fitur['keahlian'],
                'penelitian' => $fitur['penelitian'],
                'judul'      => $fitur['judul'],
                'label'      => 'Layak', // karena sudah dipilih & diterima
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Assignment pembimbing berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
