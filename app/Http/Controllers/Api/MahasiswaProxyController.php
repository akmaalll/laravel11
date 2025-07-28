<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class MahasiswaProxyController extends Controller
{
    public function __invoke()
    {
        $response = Http::get('https://service.undipa.ac.id/mhs-all.php?api=071994');
        return response()->json($response->json());
    }
}
