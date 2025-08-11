<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\Repositories\Contracts\ProdiContract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Repositories\Contracts\KeahlianContract;
use App\Models\Dosen;
use App\Models\Keahlian;
use App\Services\NaiveBayesKeahlianDosenService;

class KeahlianController extends Controller
{
    protected $title, $repo, $response;

    public function __construct(KeahlianContract $repo)
    {
        $this->title = 'keahlian';
        $this->repo = $repo;
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
            $result = $this->repo->paginated($request->all());
            $perPage = $request->per_page == '' ? 5 : $request->per_page;

            $view = view('admin.' . $title . '.data', [
                'data' => $result['grouped'],
                'pagination' => $result['pagination'],
                'title' => $title
            ])->with('i', ($request->input('page', 1) - 1) * $perPage)->render();

            return response()->json([
                "total_page" => $result['pagination']->lastPage(),
                "total_data" => $result['pagination']->total(),
                "html"       => $view,
            ]);
        } catch (\Exception $e) {
            dd($e);
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
            return view('admin.' . $title . '.form', compact('title', 'data'));
        } catch (\Exception $e) {
            return view('errors.message', ['message' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $req = $request->all();
            $data = $this->repo->update($req, $request->id);
            return response()->json(['data' => $data, 'success' => true]);
        } catch (\Exception $e) {
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

    public function predict($nidn)
    {
        $dosen = Dosen::with('mataKuliah')->findOrFail($nidn);
        $mataKuliah = $dosen->mataKuliah->pluck('mata_kuliah')->toArray();
        // dd($mataKuliah);

        $nb = new NaiveBayesKeahlianDosenService();
        $predictedKeahlian = $nb->predict($mataKuliah);

        return response()->json([
            'dosen' => $dosen->nama,
            'mata_kuliah' => $mataKuliah,
            'predicted_keahlian' => $predictedKeahlian
        ]);
    }

    public function assignKeahlian($nidn)
    {
        $dosen = Dosen::with('mataKuliah')->findOrFail($nidn);
        $mataKuliah = $dosen->mataKuliah->pluck('mata_kuliah')->toArray();

        $nb = new NaiveBayesKeahlianDosenService();
        $keahlian = Keahlian::firstOrCreate(['nama' => $nb->predict($mataKuliah)]);

        $dosen->keahlians()->syncWithoutDetaching([$keahlian->id]);

        return response()->json([
            'message' => 'Keahlian berhasil ditambahkan',
            'keahlian' => $keahlian->nama
        ]);
    }

    // public function generateAllKeahlian()
    // {
    //     try {
    //         // Get all dosens with mata kuliah
    //         $dosens = Dosen::has('mataKuliah')->with('mataKuliah')->get();

    //         if ($dosens->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'Tidak ada dosen yang memiliki mata kuliah',
    //                 'success' => false
    //             ], 400);
    //         }

    //         $nb = new NaiveBayesKeahlianDosenService();
    //         $results = [];
    //         $keahlianCounts = [];

    //         foreach ($dosens as $dosen) {
    //             $mataKuliah = $dosen->mataKuliah->pluck('mata_kuliah')->toArray();
    //             $predictions = $nb->predict($mataKuliah);

    //             $keahlianIds = [];
    //             $dosenKeahlians = [];

    //             foreach ($predictions as $keahlianName => $probability) {
    //                 // Only consider predictions with probability > 20%
    //                 if ($probability > 0.2) {
    //                     $keahlian = Keahlian::firstOrCreate(['nama' => $keahlianName]);
    //                     $keahlianIds[] = $keahlian->id;
    //                     $dosenKeahlians[] = [
    //                         'keahlian' => $keahlianName,
    //                         'probability' => round($probability * 100, 2) . '%'
    //                     ];

    //                     // Track keahlian counts for summary
    //                     if (!isset($keahlianCounts[$keahlianName])) {
    //                         $keahlianCounts[$keahlianName] = 0;
    //                     }
    //                     $keahlianCounts[$keahlianName]++;
    //                 }
    //             }

    //             // Sync keahlian relationships
    //             if (!empty($keahlianIds)) {
    //                 $dosen->keahlians()->syncWithoutDetaching($keahlianIds);
    //             }

    //             $results[] = [
    //                 'nidn' => $dosen->nidn,
    //                 'nama' => $dosen->nama,
    //                 'keahlians' => $dosenKeahlians,
    //                 'mata_kuliah' => $mataKuliah
    //             ];
    //         }

    //         // Prepare summary statistics
    //         arsort($keahlianCounts);
    //         $summary = [
    //             'total_dosen' => count($results),
    //             'total_keahlian_assigned' => array_sum($keahlianCounts),
    //             'keahlian_distribution' => $keahlianCounts,
    //             'top_keahlians' => array_slice($keahlianCounts, 0, 5, true)
    //         ];

    //         return response()->json([
    //             'message' => 'Berhasil generate keahlian untuk ' . count($results) . ' dosen',
    //             'data' => $results,
    //             'summary' => $summary,
    //             'success' => true
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Gagal generate keahlian: ' . $e->getMessage(),
    //             'success' => false
    //         ], 500);
    //     }
    // }

    public function generateAllKeahlian()
    {
        try {
            // Get all dosens with mata kuliah
            $dosens = Dosen::has('mataKuliah')->with('mataKuliah')->get();

            if ($dosens->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada dosen yang memiliki mata kuliah',
                    'success' => false
                ], 400);
            }

            $nb = new NaiveBayesKeahlianDosenService();
            $results = [];
            $keahlianCounts = [];
            $totalProcessed = 0;
            $totalKeahlianAssigned = 0;

            foreach ($dosens as $dosen) {
                $prediction = $nb->predictForDosen($dosen);
                $keahlianIds = [];
                $dosenKeahlians = [];

                // Process ALL predicted keahlians (no threshold filter)
                foreach ($prediction['predicted_keahlian'] as $keahlianName => $probability) {
                    // Create or get keahlian
                    $keahlian = Keahlian::firstOrCreate(['nama' => $keahlianName]);
                    $keahlianIds[] = $keahlian->id;

                    $dosenKeahlians[] = [
                        'keahlian' => $keahlianName,
                        'probability' => round($probability, 6), // Keep original decimal format
                        'percentage' => round($probability * 100, 2) . '%'
                    ];

                    // Track keahlian counts for summary
                    if (!isset($keahlianCounts[$keahlianName])) {
                        $keahlianCounts[$keahlianName] = 0;
                    }
                    $keahlianCounts[$keahlianName]++;
                    $totalKeahlianAssigned++;
                }

                // Sync ALL keahlian relationships (replace existing)
                if (!empty($keahlianIds)) {
                    $dosen->keahlians()->sync($keahlianIds); // Use sync() instead of syncWithoutDetaching()
                }

                $results[] = [
                    'nidn' => $dosen->nidn,
                    'nama' => $dosen->nama,
                    'mata_kuliah' => $prediction['mata_kuliah'],
                    'predicted_keahlian' => array_map(function ($item) {
                        return [
                            'nama' => $item['keahlian'],
                            'probability' => $item['probability'],
                            'percentage' => $item['percentage']
                        ];
                    }, $dosenKeahlians),
                    'total_keahlian' => count($dosenKeahlians)
                ];

                $totalProcessed++;
            }

            // Prepare summary statistics
            arsort($keahlianCounts);
            $summary = [
                'total_dosen_processed' => $totalProcessed,
                'total_keahlian_assigned' => $totalKeahlianAssigned,
                'average_keahlian_per_dosen' => round($totalKeahlianAssigned / $totalProcessed, 2),
                'keahlian_distribution' => $keahlianCounts,
                'top_keahlians' => array_slice($keahlianCounts, 0, 5, true),
                'unique_keahlians_count' => count($keahlianCounts)
            ];

            return response()->json([
                'message' => 'Berhasil generate keahlian untuk ' . $totalProcessed . ' dosen dengan total ' . $totalKeahlianAssigned . ' keahlian',
                'data' => $results,
                'summary' => $summary,
                'success' => true
            ]);
        } catch (\Exception $e) {
            \Log::error('Generate Keahlian Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'message' => 'Gagal generate keahlian: ' . $e->getMessage(),
                'error_details' => config('app.debug') ? $e->getTraceAsString() : null,
                'success' => false
            ], 500);
        }
    }
}
