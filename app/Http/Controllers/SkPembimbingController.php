<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Mahasiswa; // contoh model
use Illuminate\Support\Facades\DB;

class SkPembimbingController extends Controller
{
    public function generatePDF($id)
    {

        $data = DB::table('mst_judul')
            ->select(
                'mst_judul.id',
                'mst_judul.judul',
                'mhs1.username as nim',
                'mhs1.name as nama',
                'mhs2.username as nim_partner',
                'mhs2.name as nama_partner',
                'd1.nama as pembimbing1',
                'd2.nama as pembimbing2'
            )
            ->leftJoin('users as mhs1', 'mhs1.username', '=', 'mst_judul.nim1') // mahasiswa utama
            ->leftJoin('users as mhs2', 'mhs2.username', '=', 'mst_judul.nim2') // partner
            ->leftJoin('mst_dosen as d1', 'd1.nidn', '=', 'mst_judul.nidn1') // pembimbing 1
            ->leftJoin('mst_dosen as d2', 'd2.nidn', '=', 'mst_judul.nidn2') // pembimbing 2
            ->where('mst_judul.id', $id)
            ->first();


        $tanggal = now()->translatedFormat('d F Y');
        $tanggal_akhir = now()->addYear()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('pdf.sk-pembimbing', [
            'data' => [
                'nim'           => $data->nim,
                'nama'          => $data->nama,
                'nim_partner'   => $data->nim_partner,
                'nama_partner'  => $data->nama_partner,
                'judul'         => $data->judul,
                'pembimbing1'   => $data->pembimbing1,
                'pembimbing2'   => $data->pembimbing2,
            ],
            'tanggal'        => $tanggal,
            'tanggal_akhir'  => $tanggal_akhir,
        ])->setPaper('legal');

        return $pdf->download("SK_Pembimbing_{$data->nim}.pdf");
    }
}
