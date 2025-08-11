<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Services\Repositories\Contracts\PembimbingContract;
use App\Models\Dosen;
use App\Models\PengajuanJudul;
use App\Services\NaiveBayesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembimbingController extends Controller
{
    protected $title, $repo, $response, $naiveBayesService;

    public function __construct(PembimbingContract $repo, NaiveBayesService $naiveBayesService)
    {
        $this->title = 'pembimbing';
        $this->repo = $repo;
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


    //naive bayes
    public function assignSupervisors(Request $request, $pengajuanId)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'pembimbing1_id' => 'required|exists:mst_dosens,nidn',
                'pembimbing2_id' => 'required|exists:mst_dosens,nidn|different:pembimbing1_id'
            ]);

            $pengajuan = PengajuanJudul::findOrFail($pengajuanId);

            // Delete existing supervisors if any
            $this->repo->getModel()
                ->where('id_judul', $pengajuanId)
                ->delete();

            // Assign pembimbing 1
            $pembimbing1 = $this->repo->store([
                'id_judul' => $pengajuanId,
                'id_dosen' => $request->pembimbing1_id,
                'peran' => 'pembimbing_1'
            ]);

            // Assign pembimbing 2
            $pembimbing2 = $this->repo->store([
                'id_judul' => $pengajuanId,
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
            dd($e);
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
            $pengajuan = PengajuanJudul::with('prodi')->findOrFail($pengajuanId);

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
            // dd($recommendations);

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

    /**
     * Show assignment page with AI recommendations
     */
    public function showAssignment($pengajuanId = null)
    {
        try {
            $pengajuan = null;
            if ($pengajuanId) {
                $pengajuan = PengajuanJudul::with(['prodi', 'pengusuls'])->findOrFail($pengajuanId);
            }
            return view('admin.pembimbing.assignment', compact('pengajuan', 'pengajuanId'));
        } catch (\Exception $e) {
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    /**
     * Assign supervisors with AI recommendations
     */
    public function assignWithRecommendation(Request $request, $pengajuanId)
    {
        try {
            // dd($request->pembimbing_1);
            $request->validate([
                'pembimbing1_id' => 'exists:mst_dosens,nidn',
                'pembimbing2_id' => 'exists:mst_dosens,nidn|different:pembimbing1_id',
                'notes' => 'nullable|string'
            ]);

            $pengajuan = PengajuanJudul::findOrFail($pengajuanId);

            // Check if already has supervisors
            $existingPembimbings = $pengajuan->pembimbings;

            if ($existingPembimbings->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengajuan ini sudah memiliki pembimbing'
                ], 400);
            }

            // Create pembimbing 1
            $pembimbing1 = $this->repo->store([
                'id_dosen' => $request->pembimbing_1,
                'id_judul' => $pengajuanId,
                'peran' => 'pembimbing_1'
            ]);
            // dd($pembimbing1);


            // Create pembimbing 2
            $pembimbing2 = $this->repo->store([
                'id_dosen' => $request->pembimbing_2,
                'id_judul' => $pengajuanId,
                'peran' => 'pembimbing_2'
            ]);

            // Update pengajuan status
            $pengajuan->update(['status' => 'diterima']);

            // Log the assignment for training data
            Log::info("Pembimbing assigned for pengajuan {$pengajuanId}: Pembimbing1={$request->pembimbing1_id}, Pembimbing2={$request->pembimbing2_id}");

            return response()->json([
                'success' => true,
                'data' => [
                    'pembimbing1' => $pembimbing1,
                    'pembimbing2' => $pembimbing2,
                    'pengajuan' => $pengajuan
                ],
                'message' => 'Pembimbing berhasil ditetapkan'
            ]);
        } catch (\Exception $e) {
            dd($e);
            Log::error('Error in assignWithRecommendation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menetapkan pembimbing: ' . $e->getMessage()
            ], 500);
        }
    }
}
