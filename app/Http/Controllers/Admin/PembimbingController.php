<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Repositories\Contracts\DosenRecommenderContract;
use App\Http\Services\Repositories\Contracts\PembimbingContract;
use App\Models\Dosen;
use App\Models\PengajuanJudul;
use App\Services\NaiveBayesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembimbingController extends Controller
{
    protected $title, $repo, $response, $dosenRecommender, $naiveBayesService;

    public function __construct(PembimbingContract $repo, DosenRecommenderContract $dosenRecommender, NaiveBayesService $naiveBayesService)
    {
        $this->title = 'pembimbing';
        $this->repo = $repo;
        $this->dosenRecommender = $dosenRecommender;
        $this->naiveBayesService = $naiveBayesService;
    }

    public function index()
    {
        try {
            $title = $this->title;
            return view('admin.' . $title . '.index', compact('title'));
        } catch (\Exception $e) {
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    // public function getProdiCode(Request $request)
    // {
    //     $prodi = DB::table('mst_prodis')
    //         ->where('id', $request->id_prodi)
    //         ->first();

    //     return response()->json([
    //         'kode_prodi' => $prodi->kode // Pastikan kolom ini ada di tabel
    //     ]);
    // }

    public function data(Request $request)
    {
        try {
            $title = $this->title;
            $data = $this->repo->paginated($request->all());
            $perPage = $request->per_page == '' ? 5 : $request->per_page;
            $view = view('admin.' . $title . '.data', compact('data', 'title'))->with('i', ($request->input('page', 1) -
                1) * $perPage)->render();
            return response()->json([
                "total_page" => $data->lastpage(),
                "total_data" => $data->total(),
                "html"       => $view,
            ]);
        } catch (\Exception $e) {
            dd($e);
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $title = $this->title;
            return view('admin.' . $title . '.form', compact('title'));
        } catch (\Exception $e) {
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $req = $request->all();
            // dd($req);
            $data = $this->repo->store($req);
            return response()->json(['data' => $data, 'success' => true]);
        } catch (\Exception $e) {
            dd($e);
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    // public function show($id)
    // {
    //     try {
    //         $data = $this->repo->find($id);
    //         return response()->json($data);
    //     } catch (\Exception $e) {
    //         return view('errors.message', ['message' => $e->getMessage()]);
    //     }
    // }


    public function edit($id)
    {
        try {
            $title = $this->title;
            $data = $this->repo->find($id);
            // dd($data);
            return view('admin.' . $title . '.form', compact('title', 'data'));
        } catch (\Exception $e) {
            dd($e);
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $nim)
    {
        try {
            $req = $request->all();
            $data = $this->repo->update($req, $nim);
            return response()->json(['data' => $data, 'success' => true]);
        } catch (\Exception $e) {
            dd($e);
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->repo->delete($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    public function getRecommendation($pengajuanId)
    {
        try {
            $pengajuan = PengajuanJudul::findOrFail($pengajuanId);

            if (!$pengajuan->topik) {
                return response()->json([
                    'success' => false,
                    'message' => 'Topik pengajuan tidak ditemukan'
                ], 400);
            }

            // Get multiple recommendations
            $recommendations = $this->dosenRecommender->getMultipleRecommendations($pengajuan->topik, 3);
            // dd($recommendations);

            if (empty($recommendations)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ditemukan dosen yang sesuai dengan topik'
                ], 404);
            }

            // Assign pembimbing 1 dan 2
            $pembimbing1 = $recommendations[0] ?? null;
            $pembimbing2 = $recommendations[1] ?? null;

            // dd($pembimbing1, $pembimbing2);

            // Jika hanya ada 1 rekomendasi, cari pembimbing 2 secara random
            if (!$pembimbing2) {
                $pembimbing2 = Dosen::where('nidn', '!=', $pembimbing1->nidn)
                    ->inRandomOrder()
                    ->first();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'pembimbing1' => $pembimbing1,
                    'pembimbing2' => $pembimbing2,
                    'all_recommendations' => $recommendations
                ],
                'message' => 'Rekomendasi pembimbing berhasil dibuat'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getRecommendation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat rekomendasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recommendation using similarity approach (alternative method)
     */
    public function getRecommendationSimilarity($pengajuanId)
    {
        try {
            $pengajuan = PengajuanJudul::findOrFail($pengajuanId);

            if (!$pengajuan->topik) {
                return response()->json([
                    'success' => false,
                    'message' => 'Topik pengajuan tidak ditemukan'
                ], 400);
            }

            // Get recommendation using similarity
            $pembimbing1 = $this->dosenRecommender->recommendWithSimilarity($pengajuan->topik, 3);

            if (!$pembimbing1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ditemukan dosen yang sesuai dengan topik'
                ], 404);
            }

            // Get second supervisor
            $pembimbing2 = $this->dosenRecommender->recommendWithSimilarity($pengajuan->topik, 2);

            // Pastikan pembimbing 2 berbeda dari pembimbing 1
            if (!$pembimbing2 || $pembimbing2->nidn == $pembimbing1->nidn) {
                $pembimbing2 = Dosen::where('nidn', '!=', $pembimbing1->nidn)
                    ->inRandomOrder()
                    ->first();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'pembimbing1' => $pembimbing1,
                    'pembimbing2' => $pembimbing2
                ],
                'message' => 'Rekomendasi pembimbing berhasil dibuat menggunakan similarity'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getRecommendationSimilarity: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat rekomendasi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function assignSupervisors(Request $request, $pengajuanId)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'pembimbing1_id' => 'required|exists:dosens,nidn',
                'pembimbing2_id' => 'required|exists:dosens,nidn|different:pembimbing1_id'
            ]);

            $pengajuan = PengajuanJudul::findOrFail($pengajuanId);

            // Delete existing supervisors if any
            $this->repo->getModel()
                ->where('id_pengajuan', $pengajuanId)
                ->delete();

            // Assign pembimbing 1
            $pembimbing1 = $this->repo->store([
                'id_pengajuan' => $pengajuanId,
                'id_dosen' => $request->pembimbing1_id,
                'peran' => 'pembimbing_1'
            ]);

            // Assign pembimbing 2
            $pembimbing2 = $this->repo->store([
                'id_pengajuan' => $pengajuanId,
                'id_dosen' => $request->pembimbing2_id,
                'peran' => 'pembimbing_2'
            ]);

            // Update status pengajuan if needed
            $pengajuan->update(['status' => 'assigned']);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'pembimbing1' => $pembimbing1,
                    'pembimbing2' => $pembimbing2
                ],
                'message' => 'Pembimbing berhasil ditetapkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in assignSupervisors: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menetapkan pembimbing: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableDosens()
    {
        try {
            $dosens = Dosen::with(['keahlians' => function ($query) {
                $query->select('id', 'nama');
            }])->get();

            return response()->json([
                'success' => true,
                'data' => $dosens
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getAvailableDosens: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dosen'
            ], 500);
        }
    }

    /**
     * Get pembimbing history for a specific pengajuan
     */
    public function getPembimbingHistory($pengajuanId)
    {
        try {
            $pembimbings = $this->repo->getModel()
                ->with(['dosen', 'pengajuan'])
                ->where('id_pengajuan', $pengajuanId)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $pembimbings
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getPembimbingHistory: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil history pembimbing'
            ], 500);
        }
    }

    /**
     * Get recommendation using Naive Bayes with 3 attributes
     */
    public function getRecommendationNaiveBayes($pengajuanId)
    {
        try {
            $pengajuan = PengajuanJudul::findOrFail($pengajuanId);

            if (!$pengajuan->topik) {
                return response()->json([
                    'success' => false,
                    'message' => 'Topik pengajuan tidak ditemukan'
                ], 400);
            }

            // Get recommendations using Naive Bayes
            $recommendations = $this->naiveBayesService->predictDosenPembimbing(
                $pengajuan->judul,
                $pengajuan->topik,
                $pengajuan->konsentrasi,
                5
            );

            if (empty($recommendations)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ditemukan dosen yang sesuai dengan kriteria'
                ], 404);
            }

            // Format response
            $formattedRecommendations = [];
            foreach ($recommendations as $rec) {
                $formattedRecommendations[] = [
                    'dosen' => $rec['dosen'],
                    'score' => round($rec['score'], 4),
                    'attributes' => [
                        'keahlian' => $rec['attributes']['keahlian'],
                        'mata_kuliah' => $rec['attributes']['mata_kuliah'],
                        'history_bimbingan' => $rec['attributes']['history_bimbingan'],
                        'history_penelitian' => $rec['attributes']['history_penelitian']
                    ]
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'pengajuan' => $pengajuan,
                    'recommendations' => $formattedRecommendations,
                    'top_recommendations' => array_slice($formattedRecommendations, 0, 2)
                ],
                'message' => 'Rekomendasi pembimbing menggunakan Naive Bayes berhasil dibuat'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getRecommendationNaiveBayes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat rekomendasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Train Naive Bayes model
     */
    public function trainNaiveBayesModel()
    {
        try {
            $result = $this->naiveBayesService->trainModel();

            return response()->json([
                'success' => true,
                'message' => 'Model Naive Bayes berhasil dilatih'
            ]);
        } catch (\Exception $e) {
            Log::error('Error training Naive Bayes model: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal melatih model: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save training data after successful supervision
     */
    public function saveTrainingData(Request $request)
    {
        try {
            $request->validate([
                'pengajuan_id' => 'required|string',
                'dosen_nidn' => 'required|string',
                'hasil_pembimbingan' => 'required|in:berhasil,kurang_berhasil,gagal'
            ]);

            $result = $this->naiveBayesService->saveTrainingData(
                $request->pengajuan_id,
                $request->dosen_nidn,
                $request->hasil_pembimbingan
            );

            return response()->json([
                'success' => true,
                'message' => 'Data training berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving training data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data training: ' . $e->getMessage()
            ], 500);
        }
    }
}
