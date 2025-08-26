<?php

namespace App\Http\Controllers;

use App\Http\Services\Repositories\Contracts\datasContract;
use App\Http\Services\Repositories\Contracts\UsersContract;
use App\Models\Judul;
use App\Models\Mahasiswa;
use App\Models\PengajuanJudul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
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

    protected $repo;

    public function __construct(UsersContract $repo)
    {
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

        $totalPengajuan = DB::table('mst_judul')
            ->where('nim1', $stb)
            ->orWhere('nim2', $stb)
            ->get();
        // dd($totalPengajuan);
        return view('app.home', compact('totalPengajuan'));
    }

    public function pengajuan()
    {
        return view('app.pengajuan-judul.index');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerStore(Request $r)
    {
        try {
            $req = $r->all();
            $userData = [
                'name' => $req['name'],
                'username' => $req['username'],
                'email' => $req['email'],
                'password' => Hash::make($req['password']),
                'id_role' => 2, // Role mahasiswa
            ];
            $data = $this->repo->store($userData);

            $mahasiswa = Mahasiswa::create([
                'id_user' => $data->id,
                'nim' => $req['nim'],
                'prodi' => $req['prodi'],
                'angkatan' => $req['angkatan'],
            ]);
            if ($data) {
                return redirect()->route('admin.login');
            } else {
                return redirect()->back();
            }
        } catch (\Exception $e) {
            dd($e);
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    public function registerSuccess()
    {
        return view('auth.message');
    }
}
