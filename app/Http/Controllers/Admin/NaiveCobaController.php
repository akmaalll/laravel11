<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Atribut;
use App\Models\NaiveBayesTraningData;
use Illuminate\Support\Facades\DB;

class NaiveCobaController extends Controller
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
            $dataPengajuan = DB::table('mst_judul')->where('status', 'diajukan')->first();
            return view('admin.pembimbing.tesviewrong', compact('title', 'dataPengajuan'));
        } catch (\Exception $e) {
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }



    public function getJudulPengajuan($id)
    {
        $dataPengajuan = DB::table('mst_judul')
            ->leftJoin('mst_keahlian', 'mst_keahlian.id', '=', 'mst_judul.id_keahlian')
            ->leftJoin('users as u', 'u.username', '=', 'mst_judul.nim1')
            ->leftJoin('users as u2', 'u2.username', '=', 'mst_judul.nim2')
            ->select(
                'mst_judul.*',
                'mst_keahlian.nama as nama_keahlian',
                'u.name as nama_mhs1',
                'u2.name as nama_mhs2'
            )
            ->where('mst_judul.id', $id)
            ->first();
        $hasilFilterKeahlian = DB::table('keahliandosenview')
            ->select('nidn', 'nama', DB::raw("COUNT(nidn) as jumlah_dosen"))
            ->where('id_keahlian', '=', $dataPengajuan->id_keahlian)
            ->whereNotNull('nidn')
            ->groupBy('nidn')
            ->get();

        $hasilFilterPenelitian = DB::table('penelitiandosenview')
            ->select('nidn', 'nama', DB::raw("COUNT(nidn) as jumlah_dosen"))
            ->where('id_keahlian', '=', $dataPengajuan->id_keahlian)
            ->whereNotNull('nidn')
            ->groupBy('nidn')
            ->get();

        $hasilFilterJudul1 = DB::table('mst_judul')
            ->select(DB::raw("'p1' as pembimbing"), "id_keahlian", "nidn1 as nidn", DB::raw("COUNT(nidn1) as jumlah"))
            ->whereNotNull('mst_judul.nidn1')
            ->whereNotNull('mst_judul.nidn2')
            ->where("status", "=", "diterima")
            ->where("id_keahlian", "=", $dataPengajuan->id_keahlian)
            ->groupBy("nidn1")
            ->get();

        $hasilFilterJudul2 = DB::table('mst_judul')
            ->select(DB::raw("'p2' as pembimbing1"), 'id_keahlian', 'nidn2 as nidn', DB::raw("COUNT(nidn2) as jumlah"), DB::raw("'1' as aktif"))
            ->whereNotNull('nidn1')
            ->whereNotNull('nidn2')
            ->where('id_keahlian', '=', $dataPengajuan->id_keahlian)
            ->where('status', '=', 'diterima')
            ->groupBy('nidn2')
            ->get();


        foreach ($hasilFilterJudul1 as $i => $j1) {
            foreach ($hasilFilterJudul2 as $j2) {
                if ($j1->nidn == $j2->nidn) {
                    $hasilFilterJudul1[$i]->jumlah = $j1->jumlah + $j2->jumlah;
                    $j2->aktif = 0;
                }
            }
        }

        $hapusAktif =  $hasilFilterJudul2->map(function ($item) {
            $array = (array) $item;
            unset($array['aktif']);
            return (object) $array;
        });

        $hasilRiwayat  = array_merge($hasilFilterJudul1->toArray(), $hapusAktif->toArray());

        $c1 = $hasilFilterKeahlian->toArray();
        $c2 = $hasilFilterPenelitian->toArray();
        $c3 = $hasilRiwayat;

        $nidnKeahlian = collect($c1)->pluck('nidn')->toArray();
        $penelitianFiltered = array_filter($c2, function ($item) use ($nidnKeahlian) {
            return !in_array($item->nidn, $nidnKeahlian);
        });

        $hasilAkhir = [];

        foreach ($c1 as $item) {
            $hasilAkhir[$item->nidn] = [
                'nidn' => $item->nidn,
                'nama' => $item->nama,
                'jumlah_keahlian' => $item->jumlah_dosen,
                'jumlah_penelitian' => 0,
                'jumlah_riwayat' => 0,
            ];
        }

        foreach ($penelitianFiltered as $item) {
            $hasilAkhir[$item->nidn] = [
                'nidn' => $item->nidn,
                'nama' => $item->nama,
                'jumlah_keahlian' => 0,
                'jumlah_penelitian' => $item->jumlah_dosen,
                'jumlah_riwayat' => 0,
            ];
        }

        foreach ($c3 as $riwayat) {
            if (isset($hasilAkhir[$riwayat->nidn])) {
                $hasilAkhir[$riwayat->nidn]['jumlah_riwayat'] = $riwayat->jumlah;
                $riwayat->jumlah;
            } else {
                $hasilAkhir[$riwayat->nidn] = [
                    'nidn' => $riwayat->nidn,
                    'nama' => 'Unknown',
                    'jumlah_keahlian' => 0,
                    'jumlah_penelitian' => 0,
                    'jumlah_riwayat' => $riwayat->jumlah,
                ];
            }
        }

        $nassami = [];
        $getXX = $this->getXX();
        $pStatus =  [];


        foreach ($getXX as $item => $i) {
            $pStatus[$item] = 0;
        }

        foreach ($hasilAkhir as $i => $item) {
            $r = $item['jumlah_keahlian'] + $item['jumlah_penelitian'] + $item['jumlah_riwayat'];

            //hitung pStatus (Tidak Rekomendasi, Disarankan, Rekomendasi)
            foreach ($getXX as $it => $ix)
                if ($ix['nilai_awal'] <= $r && $ix['nilai_akhir'] >= $r)
                    $pStatus[$it] = $pStatus[$it] + 1;

            $nassami[$i] = [
                'nidn' => $item['nidn'],
                'nama' => $item['nama'],
                'jumlah_keahlian' => $item['jumlah_keahlian'],
                'jumlah_penelitian' => $item['jumlah_penelitian'],
                'jumlah_riwayat' => $item['jumlah_riwayat'],
                'rekomendasi' => $r
            ];
        }

        NaiveBayesTraningData::truncate();
        NaiveBayesTraningData::insert($nassami);
        NaiveBayesTraningData::where('nama', 'Unknown')->delete();

        $psat = [];
        //nilai Rekomendasi Dosen (Tidak Rekomendasi, Disarankan, Rekomendasi)
        for ($c = 0; $c < count($getXX); $c++) {
            $psat[$c] = $pStatus[$c] / count($nassami);
        }

        $prob = DB::table('probabilitas')->get();
        $results = [];

        foreach ($prob as $i => $row) {
            if ($row->disarankan > 0) {
                $disarankan =  $row->disarankan / $pStatus[0];
                // dd($row->disarankan . ' / ' . $pStatus[0] . ' = ' . $disarankan);
            } else {
                $disarankan = 0;
            }

            if ($row->rekomendasi > 0) {
                $rekomendasi =  $row->rekomendasi / $pStatus[1];
            } else {
                $rekomendasi = 0;
            }

            $results[$i] = [
                'info' => $row->info,
                'nilai' => $row->nilai,
                'disarankan' => $disarankan,
                'rekomendasi' => $rekomendasi,
                'disarankan_awal' => $row->disarankan,
                'rekomendasi_awal' => $row->rekomendasi,
                'perhitungan_disarankan' => $row->disarankan . ' / ' . $pStatus[0] . ' = ' . $disarankan,
                'perhitungan_rekomendasi' => $row->rekomendasi . ' / ' . $pStatus[1] . ' = ' . $rekomendasi
            ];
        }

        $datanassami = DB::table('trainingnassamiview')->get();
        $skorDisarankan = [];
        $skorRekomendasi = [];
        foreach ($datanassami as $i => $item) {
            $disKeahlian = 0;
            $rekKeahlian = 0;
            $disPenelitian = 0;
            $rekPenelitian = 0;
            $disRiwayat = 0;
            $rekRiwayat = 0;
            foreach ($results as $j => $row) {
                if ($item->label_keahlian == $row['nilai']) {
                    $disKeahlian = $row['disarankan'];
                    $rekKeahlian = $row['rekomendasi'];
                } elseif ($item->label_penelitian == $row['nilai']) {
                    $disPenelitian = $row['disarankan'];
                    $rekPenelitian = $row['rekomendasi'];
                } elseif ($item->label_riwayat == $row['nilai']) {
                    $disRiwayat = $row['disarankan'];
                    $rekRiwayat = $row['rekomendasi'];
                }
            }

            $dis = $disKeahlian * $disPenelitian * $disRiwayat * $psat[0];
            $prosesDis = substr($disKeahlian, 0, 5) . ' * ' . substr($disPenelitian, 0, 5) . ' * ' . substr($disRiwayat, 0, 5) . ' * ' . substr($psat[0], 0, 5);
            $rek = $rekKeahlian * $rekPenelitian * $rekRiwayat * $psat[1];
            $prosesRek = substr($rekKeahlian, 0, 5) . ' * ' . substr($rekPenelitian, 0, 5) . ' * ' . substr($rekRiwayat, 0, 5) . ' * ' . substr($psat[1], 0, 5);

            $jabatan = DB::table('mst_dosen')->where('nidn', $item->nidn)->first();
            // dd($jabatan->jabatan_fungsional);
            if ($dis > $rek) {
                $skorDisarankan[$i] = [
                    'nidn' => $item->nidn,
                    'nama' => $item->nama,
                    'jabatan_fungsional' => $jabatan == null ? '-' : $jabatan->jabatan_fungsional,
                    'perhitungan_label' => $prosesDis,
                    'skor' => substr($dis, 0, 5),
                    'status' => 'disarankan'
                ];
            } else {
                $skorRekomendasi[$i] = [
                    'nidn' => $item->nidn,
                    'nama' => $item->nama,
                    'jabatan_fungsional' => $jabatan == null ? '-' : $jabatan->jabatan_fungsional,
                    'perhitungan_label' => $prosesRek,
                    'skor' => substr($rek, 0, 5),
                    'status' => 'rekomendasi'
                ];
            }
        }

        $disarankanLektor = [];
        $rekomendasiLektor = [];
        $disarankanAhli = [];
        $rekomendasiAhli = [];
        $c = 0;
        $d = 0;

        foreach ($skorDisarankan as $i => $item) {
            if ($item['nama'] != null) {
                if ($item['jabatan_fungsional'] == 'lektor') {
                    $disarankanLektor[$c] = $item;
                    $c++;
                } else {
                    $disarankanAhli[$d] = $item;
                    $d++;
                }
            }
        }

        $c = 0;
        $d = 0;

        foreach ($skorRekomendasi as $i => $item) {
            if ($item['nama'] != null) {
                if ($item['jabatan_fungsional'] == 'lektor') {
                    $rekomendasiLektor[$c] = $item;
                    $c++;
                } else {
                    $rekomendasiAhli[$d] = $item;
                    $d++;
                }
            }
        }
        // dd($disarankanAhli, $disarankanLektor, $rekomendasiAhli, $rekomendasiLektor);

        $sortDisarankanLektor = $this->bubbleSort($disarankanLektor);
        $sortRekomendasiLektor = $this->bubbleSort($rekomendasiLektor);

        $sortDisarankanAhli = $this->bubbleSort($disarankanAhli);
        $sortRekomendasiAhli = $this->bubbleSort($rekomendasiAhli);

        //hasilna mi ini
        $dataLatih = DB::table('naive_bayes_training_data')->where('nama', '<>', null)->get();
        $atribut = Atribut::orderBy('id', 'asc')->get();


        return view('admin.pembimbing.hasilalgoritma', compact('dataPengajuan', 'datanassami', 'atribut', 'dataLatih', 'prob', 'psat', 'results', 'sortDisarankanLektor', 'sortRekomendasiLektor', 'sortDisarankanAhli', 'sortRekomendasiAhli'));
        // return redirect()->route('assignment', compact('datanassami', 'atribut', 'dataLatih', 'prob', 'psat', 'sortDisarankanLektor', 'sortRekomendasiLektor', 'sortDisarankanAhli', 'sortRekomendasiAhli'));
    }

    function bubbleSort($arr)
    {
        $n = count($arr);

        // Traverse through all array elements
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arr[$j]['skor'] > $arr[$j + 1]['skor']) {
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }

        return $arr;
    }

    public function assign(Request $request)
    {

        try {
            DB::table('mst_judul')
                ->where('id', $request->judul_id)
                ->update([
                    'nidn1'     => $request->pembimbing1,
                    'nidn2'     => $request->pembimbing2,
                    'status'    => 'Diterima',
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembimbing berhasil di-assign!'
            ]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function hasilAlgoritma()
    // {
    //     // $hasilAlgoritma = DB::table('trainingnassamiview')->get();
    //     $dataLatih = DB::table('naive_bayes_training_data')->get();
    //     //ambil data atribut
    //     $atribut = Atribut::orderBy('id', 'asc')->get();

    //     return view('admin.pembimbing.hasilalgoritma', compact('hasilAlgoritma', 'atribut', 'dataLatih'));
    // }

    private function getXX()
    {
        $atribut = Atribut::where('kode', 'XX')->orderBy('id', 'asc')->get();

        $arrayA = [];
        foreach ($atribut as $i => $item) {
            $arrayA[$i] = [
                'id' => $item->id,
                'kode' => $item->kode,
                'nama' => $item->nama,
                'nilai_awal' => $item->nilai_awal,
                'nilai_akhir' => $item->nilai_akhir,
            ];
        }

        return $arrayA;
    }
}
