<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

use App\Http\Services\Repositories\Contracts\PengajuanJudulContract;
use App\Http\Services\Repositories\Contracts\PengusulJudulContract;
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

    protected $repo, $pengusul;

    public function __construct(PengajuanJudulContract $repo, PengusulJudulContract $pengusul)
    {
        $this->title = 'pengajuan-judul';
        $this->repo = $repo;
        $this->pengusul = $pengusul;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = PengajuanJudul::with('pengusuls')->WhereHas('pengusuls', function ($query) {
            $query->where('nim', Session::get('stb'));
        })->count();
        // dd($data);
        return view('app.pengajuan-judul.index', ['data' => $data]);
    }

    public function data(Request $request)
    {
        try {
            $title = $this->title;
            $data = $this->repo->paginatedByUser($request->all());
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
        // if (!Session::has('form_uuid')) {
        $uuid = Uuid::uuid4()->toString();
        Session::put('form_uuid', $uuid);
        // }
        return view('app.pengajuan-judul.index-step1', ['step' => 1, 'uuid' => $uuid]);
    }
    public function step2()
    {

        if (!Session::has('form_uuid')) {
            return redirect()->route('pengajuan.step1');
        }
        $data = PengajuanJudul::where('id', Session::get('form_uuid'))->first();

        Session::put('form_uuid', Session::get('form_uuid'));

        return view('app.pengajuan-judul.index-step2', ['step' => 2, 'uuid' => Session::get('form_uuid'), 'data' => $data]);
    }
    public function step3()
    {
        Session::put('form_uuid', Session::get('form_uuid'));
        $data = PengajuanJudul::where('id', Session::get('form_uuid'))->first();
        // dd($data);
        if (!Session::has('form_uuid')) {
            return redirect()->route('pengajuan.step1');
        }
        return view('app.pengajuan-judul.index-step3', ['step' => 3, 'uuid' => Session::get('form_uuid'), 'data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $req = $request->all();
            $req['uuid'] = Session::get('form_uuid');
            $currentStep = $req['step'];
            $nextStep = $currentStep + 1;

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
                $existingRecord = DB::table('pengajuan_juduls')
                    ->where('id', $req['uuid'])
                    ->first();

                if ($existingRecord && $currentStep == 3) {
                    // dd($req['nim']);
                    foreach ($req['mahasiswas'] as $mahasiswa) {
                        $this->pengusul->store([
                            'id_judul' => $existingRecord->id,
                            'nim' => $mahasiswa['nim'],
                            'nama' => $mahasiswa['nama']
                        ]);
                    }
                    Session::forget('form_uuid');
                }
            }
            $data = PengajuanJudul::with('pengusuls')->WhereHas('pengusuls', function ($query) {
                $query->where('nim', Session::get('stb'));
            })->count();

            if ($currentStep == 2 && $data < 3) {
                if ($existingRecord) {
                    $this->repo->update($req, $existingRecord->id);
                    return response()->json([
                        'success' => true,
                        'step' => $nextStep + 1,
                        'message' => 'Data Update successfully'
                    ]);
                } else {
                    $this->repo->store($req);
                    return response()->json([
                        'success' => true,
                        'step' => $nextStep + 1,
                        'message' => 'Data saved successfully'
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Sudah tidak bisa tambah data'
                ]);
            }

            return response()->json([
                'success' => true,
                'step' => $nextStep,
                'message' => 'Data saved successfully'
            ]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
