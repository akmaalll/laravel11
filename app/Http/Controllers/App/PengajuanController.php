<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Services\Repositories\Contracts\JudulContract;
use App\Http\Services\Repositories\Contracts\PengajuanJudulContract;
use App\Http\Services\Repositories\Contracts\PengusulJudulContract;
use App\Models\Judul;
use App\Models\PengajuanJudul;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $repo, $title;

    public function __construct(JudulContract $repo)
    {
        $this->title = 'pengajuan-judul';
        $this->repo = $repo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stb = Session::get('stb'); // Ambil NIM dari session

        $data = DB::table('mst_judul')
            ->where('nim1', $stb)
            ->orWhere('nim2', $stb)
            ->count();
        // dd($data);
        return view('app.pengajuan-judul.index', ['data' => $data]);
    }

    public function show($id)
    {
        try {
            $data = DB::table('mst_judul as j')
                ->leftJoin('mst_keahlian as k', 'k.id', '=', 'j.id_keahlian')
                ->leftJoin('users as u', 'u.username', '=', 'j.nim1')
                ->leftJoin('users as u2', 'u2.username', '=', 'j.nim2')
                ->select(
                    'j.*',
                    'k.nama as nama_keahlian',
                    'u.name as nama_mhs1',
                    'u2.name as nama_mhs2'
                )
                ->where('j.id', $id)
                ->first();

            if (!$data) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function data(Request $request)
    {
        try {
            $title = $this->title;
            $data = $this->repo->paginatedMhs($request->all());
            $perPage = $request->per_page == '' ? 5 : $request->per_page;
            $view = view('app.' . $title . '.data', compact('data', 'title'))->with('i', ($request->input('page', 1) -
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
    public function step1()
    {
        // Generate a new UUID only if one doesn't exist in session
        if (!Session::has('form_uuid')) {
            $uuid = Uuid::uuid4()->toString();
            Session::put('form_uuid', $uuid);
        }

        return view('app.pengajuan-judul.index-step1', [
            'step' => 1,
            'uuid' => Session::get('form_uuid')
        ]);
    }

    public function step2()
    {

        if (!Session::has('form_uuid')) {
            return redirect()->route('pengajuan.step1');
        }
        // $data = Judul::where('id', Session::get('form_uuid'))->first();
        $data = DB::table('mst_judul')
            ->leftJoin('mst_keahlian', 'mst_judul.id_keahlian', '=', 'mst_keahlian.id')
            ->select('mst_judul.*', 'mst_keahlian.nama as nama_keahlian')
            ->where('mst_judul.id', Session::get('form_uuid'))->first();

        Session::put('form_uuid', Session::get('form_uuid'));

        return view('app.pengajuan-judul.index-step2', ['step' => 2, 'uuid' => Session::get('form_uuid'), 'data' => $data]);
    }
    public function step3()
    {
        Session::put('form_uuid', Session::get('form_uuid'));
        // $data = Judul::where('id', Session::get('form_uuid'))->first();
        $data = DB::table('mst_judul')
            ->select('mst_judul.*', 'mst_keahlian.nama as nama_keahlian', 'mst_prodi.nama as nama_prodi')
            ->join('mst_keahlian', 'mst_judul.id_keahlian', '=', 'mst_keahlian.id')
            ->join('mst_prodi', 'mst_prodi.id', '=', 'mst_judul.id_prodi')
            ->where('mst_judul.id', Session::get('form_uuid'))
            ->first();

        $nama = Session::get('nama_mhs');
        // dd($data);

        if (!Session::has('form_uuid')) {
            return redirect()->route('pengajuan.step1');
        }
        return view('app.pengajuan-judul.index-step3', ['step' => 3, 'uuid' => Session::get('form_uuid'), 'data' => $data, 'nama' => $nama]);
    }

    public function store(Request $request)
    {
        try {
            $req = $request->all();
            $req['uuid'] = Session::get('form_uuid');
            $currentStep = $req['step'];
            $nextStep = $currentStep + 1;

            $currentCount = Judul::where('nim1', Session::get('stb'))->count();

            if ($currentCount >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mencapai batas maksimal pengajuan (3 judul)',
                    'redirect' => route('pengajuan.index')
                ], 403);
            }

            // Jalankan validator hanya pada step 2
            if ($currentStep == 2) {
                $validator = Validator::make($req, [
                    'step' => 'required|integer',
                    'latar_belakang' => 'required',
                    'konsentrasi' => 'required',
                    'tujuan_penelitian' => 'required',
                    'rumusan_masalah' => 'required',
                    'penelitian_terkait' => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }
            }

            if (isset($req['uuid'])) {
                $existingRecord = DB::table('mst_judul')
                    ->where('id', $req['uuid'])
                    ->first();


                if ($existingRecord && $currentStep == 3) {
                    // dd($req);
                    if (isset($req['nim1']) && isset($req['nim2'])) {
                        $dataToUpdate = [
                            'nim1' => $req['nim1'],
                            'nim2' => $req['nim2'],
                            'status' => 'draft',
                        ];
                        $this->repo->update($dataToUpdate, $existingRecord->id);
                    } else {
                        $req['nim1'] = Session::get('stb');
                        $req['status'] = 'draft';
                        $this->repo->update($req, $existingRecord->id);
                    }
                    Session::forget('form_uuid');
                }
            }


            if ($currentStep == 2) {
                if ($existingRecord) {
                    $this->repo->update($req, $existingRecord->id);
                    return response()->json([
                        'success' => true,
                        'step' => $nextStep + 1,
                        'message' => 'Data Update successfully'
                    ]);
                } else {
                    // dd($existingRecord);
                    $this->repo->store($req);
                    return response()->json([
                        'success' => true,
                        'step' => $nextStep + 1,
                        'message' => 'Data saved successfully'
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'step' => $nextStep,
                'message' => 'Data saved successfully',
            ]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function approveByNim2($id)
    {
        try {
            $judul = Judul::findOrFail($id);

            // Pastikan user yang login adalah nim2
            if ($judul->nim2 != Session::get('stb')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berhak menyetujui judul ini'
                ], 403);
            }

            // Update status jadi diajukan
            $judul->update([
                'status' => 'diajukan'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Judul berhasil diajukan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function rejectByNim2($id)
    {
        try {
            $judul = Judul::findOrFail($id);

            // pastikan yang reject adalah nim2
            if ($judul->nim2 != Session::get('stb')) {
                return back()->with('error', 'Anda tidak berhak menolak judul ini.');
            }

            $judul->update([
                'nim2' => null,
                'status' => 'draft'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Judul Berhasil Dihapus'
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function editStep2($id)
    {
        $judul = Judul::findOrFail($id);

        // simpan uuid di session biar bisa dipakai lagi di store()
        Session::put('form_uuid', $judul->id);

        // langsung redirect ke form step 2
        return redirect()->route('pengajuan.step2', [
            'step' => 2,
            'id' => $judul->id
        ]);
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
}
