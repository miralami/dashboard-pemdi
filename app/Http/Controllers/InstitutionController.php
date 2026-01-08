<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpbeData;

class InstitutionController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        return view('landing');
    }

    /**
     * Get institutions list with categories for the form
     */
    public function getInstitutions(Request $request)
    {
        $search = $request->input('search', '');
        $category = $request->input('category', '');

        $query = SpbeData::select('kode', 'nama_instansi', 'kategori')
            ->distinct();

        if ($search) {
            $query->where('nama_instansi', 'LIKE', "%{$search}%");
        }

        if ($category) {
            $query->where('kategori', $category);
        }

        $institutions = $query->orderBy('nama_instansi', 'asc')->get();

        return response()->json($institutions);
    }

    /**
     * Get available categories
     */
    public function getCategories()
    {
        $categories = SpbeData::select('kategori')
            ->distinct()
            ->whereNotNull('kategori')
            ->orderBy('kategori', 'asc')
            ->pluck('kategori');

        return response()->json($categories);
    }

    /**
     * Get all provinces from daerah field
     */
    public function getProvinces()
    {
        // Extract provinces from daerah field (format: "PROV. PROVINCE_NAME")
        $provinces = SpbeData::select('daerah')
            ->distinct()
            ->whereNotNull('daerah')
            ->where('daerah', 'LIKE', 'PROV.%')
            ->orderBy('daerah', 'asc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->daerah,
                    'name' => str_replace('PROV. ', '', $item->daerah)
                ];
            });

        return response()->json($provinces);
    }

    /**
     * Get Kabupaten/Kota based on province
     */
    public function getKabKota($provinceId)
    {
        // Extract province name from format "PROV. NAME"
        $provinceName = str_replace('PROV. ', '', $provinceId);

        // Get unique kabupaten/kota that contain institutions
        $allKabKota = SpbeData::select('daerah')
            ->distinct()
            ->whereNotNull('daerah')
            ->where('daerah', 'NOT LIKE', 'PROV.%')
            ->where(function($query) {
                $query->where('daerah', 'LIKE', 'KAB.%')
                      ->orWhere('daerah', 'LIKE', 'KOTA%');
            })
            ->orderBy('daerah', 'asc')
            ->pluck('daerah');

        // Filter kabupaten/kota that belong to the province using administrative mapping
        $kabkota = $allKabKota->filter(function($daerah) use ($provinceName) {
            return $this->belongsToProvince($daerah, $provinceName);
        })->map(function($daerah) {
            return [
                'id' => $daerah,
                'name' => preg_replace('/^(KAB\.|KOTA) /', '', $daerah),
                'province' => $this->extractProvinceFromRegion($daerah)
            ];
        })->values();

        return response()->json($kabkota);
    }

    /**
     * Check if a kabupaten/kota belongs to a province
     * Uses Indonesian administrative region mapping
     */
    private function belongsToProvince($kabkotaName, $provinceName)
    {
        // Province to regions mapping (Indonesian administrative data)
        $mapping = [
            'ACEH' => ['ACEH'],
            'SUMATERA UTARA' => ['SUMATERA UTARA'],
            'SUMATERA BARAT' => ['SUMATERA BARAT'],
            'RIAU' => ['RIAU'],
            'JAMBI' => ['JAMBI'],
            'SUMATERA SELATAN' => ['SUMATERA SELATAN'],
            'BENGKULU' => ['BENGKULU'],
            'LAMPUNG' => ['LAMPUNG'],
            'KEP. BANGKA BELITUNG' => ['BANGKA', 'BELITUNG'],
            'KEPULAUAN RIAU' => ['KEPULAUAN RIAU', 'KEP. RIAU'],
            'DKI JAKARTA' => ['JAKARTA'],
            'JAWA BARAT' => ['JAWA BARAT'],
            'JAWA TENGAH' => ['JAWA TENGAH'],
            'DI YOGYAKARTA' => ['YOGYAKARTA', 'SLEMAN', 'BANTUL', 'KULON PROGO', 'GUNUNG KIDUL'],
            'JAWA TIMUR' => ['JAWA TIMUR'],
            'BANTEN' => ['BANTEN'],
            'BALI' => ['BALI'],
            'NUSA TENGGARA BARAT' => ['NUSA TENGGARA BARAT', 'NTB'],
            'NUSA TENGGARA TIMUR' => ['NUSA TENGGARA TIMUR', 'NTT'],
            'KALIMANTAN BARAT' => ['KALIMANTAN BARAT'],
            'KALIMANTAN TENGAH' => ['KALIMANTAN TENGAH'],
            'KALIMANTAN SELATAN' => ['KALIMANTAN SELATAN'],
            'KALIMANTAN TIMUR' => ['KALIMANTAN TIMUR'],
            'KALIMANTAN UTARA' => ['KALIMANTAN UTARA'],
            'SULAWESI UTARA' => ['SULAWESI UTARA'],
            'SULAWESI TENGAH' => ['SULAWESI TENGAH'],
            'SULAWESI SELATAN' => ['SULAWESI SELATAN'],
            'SULAWESI TENGGARA' => ['SULAWESI TENGGARA'],
            'GORONTALO' => ['GORONTALO'],
            'SULAWESI BARAT' => ['SULAWESI BARAT'],
            'MALUKU' => ['MALUKU'],
            'MALUKU UTARA' => ['MALUKU UTARA'],
            'PAPUA' => ['PAPUA'],
            'PAPUA BARAT' => ['PAPUA BARAT'],
        ];

        $kabkotaClean = strtoupper(preg_replace('/^(KAB\.|KOTA) /', '', $kabkotaName));
        $provinceUpper = strtoupper($provinceName);

        if (!isset($mapping[$provinceUpper])) {
            return false;
        }

        foreach ($mapping[$provinceUpper] as $keyword) {
            if (strpos($kabkotaClean, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract province name from region name
     */
    private function extractProvinceFromRegion($regionName)
    {
        // This extracts the province keyword from kabupaten/kota names
        $keywords = [
            'ACEH', 'SUMATERA UTARA', 'SUMATERA BARAT', 'RIAU', 'JAMBI', 'SUMATERA SELATAN',
            'BENGKULU', 'LAMPUNG', 'BANGKA', 'BELITUNG', 'JAKARTA', 'JAWA BARAT', 'JAWA TENGAH',
            'YOGYAKARTA', 'JAWA TIMUR', 'BANTEN', 'BALI', 'KALIMANTAN BARAT', 'KALIMANTAN TENGAH',
            'KALIMANTAN SELATAN', 'KALIMANTAN TIMUR', 'KALIMANTAN UTARA', 'SULAWESI UTARA',
            'SULAWESI TENGAH', 'SULAWESI SELATAN', 'SULAWESI TENGGARA', 'GORONTALO',
            'SULAWESI BARAT', 'MALUKU', 'PAPUA'
        ];

        $regionUpper = strtoupper($regionName);
        foreach ($keywords as $keyword) {
            if (strpos($regionUpper, $keyword) !== false) {
                return $keyword;
            }
        }

        return null;
    }

    /**
     * Get Kecamatan (placeholder - implement based on your data structure)
     */
    public function getKecamatan($kabkotaId)
    {
        // This is a placeholder. Implement based on how kecamatan data is stored
        return response()->json([]);
    }

    /**
     * Real-time search for institutions
     */
    public function searchInstitutions(Request $request)
    {
        // Get the latest year first
        $latestYear = SpbeData::max('tahun');

        // Build query for latest year only
        $query = SpbeData::select('kode', 'nama_instansi', 'kategori', 'daerah', 'indeks', 'tahun')
            ->where('tahun', $latestYear);

        // Search by name
        if ($request->filled('q') && trim($request->q) !== '') {
            $query->where('nama_instansi', 'LIKE', "%{$request->q}%");
        }

        // Filter by province
        if ($request->filled('provinsi') && trim($request->provinsi) !== '') {
            $provinceId = $request->provinsi;

            // For provinces, we need to include:
            // 1. Institutions with daerah = province
            // 2. Institutions with daerah = kabupaten/kota within that province
            $provinceName = str_replace('PROV. ', '', $provinceId);

            $query->where(function($q) use ($provinceId, $provinceName) {
                // Match exact province
                $q->where('daerah', $provinceId)
                  // OR match kabupaten/kota that belong to this province
                  ->orWhere(function($subQ) use ($provinceName) {
                      $subQ->where(function($kabQ) {
                          $kabQ->where('daerah', 'LIKE', 'KAB.%')
                               ->orWhere('daerah', 'LIKE', 'KOTA%');
                      })
                      ->where(function($nameQ) use ($provinceName) {
                          // Match region names that contain province keywords
                          $keywords = $this->getProvinceKeywords($provinceName);
                          foreach ($keywords as $keyword) {
                              $nameQ->orWhere('daerah', 'LIKE', "%{$keyword}%");
                          }
                      });
                  });
            });
        }

        // Filter by kabupaten/kota (this takes precedence if both province and kabkota are selected)
        if ($request->filled('kabkota') && trim($request->kabkota) !== '') {
            $query->where('daerah', $request->kabkota);
        }

        // Filter by category
        if ($request->filled('kategori') && trim($request->kategori) !== '') {
            $query->where('kategori', $request->kategori);
        }

        // Group by kode to get unique institutions with their latest data
        $institutions = $query->orderBy('indeks', 'desc')
            ->orderBy('nama_instansi', 'asc')
            ->limit(50)
            ->get()
            ->unique('kode')
            ->values();

        return response()->json($institutions);
    }

    /**
     * Get province keywords for filtering
     */
    private function getProvinceKeywords($provinceName)
    {
        $mapping = [
            'ACEH' => ['ACEH'],
            'SUMATERA UTARA' => ['SUMATERA UTARA'],
            'SUMATERA BARAT' => ['SUMATERA BARAT'],
            'RIAU' => ['RIAU'],
            'JAMBI' => ['JAMBI'],
            'SUMATERA SELATAN' => ['SUMATERA SELATAN'],
            'BENGKULU' => ['BENGKULU'],
            'LAMPUNG' => ['LAMPUNG'],
            'KEP. BANGKA BELITUNG' => ['BANGKA', 'BELITUNG'],
            'KEPULAUAN RIAU' => ['KEPULAUAN RIAU', 'KEP. RIAU'],
            'DKI JAKARTA' => ['JAKARTA'],
            'JAWA BARAT' => ['JAWA BARAT'],
            'JAWA TENGAH' => ['JAWA TENGAH'],
            'DI YOGYAKARTA' => ['YOGYAKARTA', 'SLEMAN', 'BANTUL', 'KULON PROGO', 'GUNUNG KIDUL'],
            'JAWA TIMUR' => ['JAWA TIMUR'],
            'BANTEN' => ['BANTEN'],
            'BALI' => ['BALI'],
            'NUSA TENGGARA BARAT' => ['NUSA TENGGARA BARAT', 'NTB'],
            'NUSA TENGGARA TIMUR' => ['NUSA TENGGARA TIMUR', 'NTT'],
            'KALIMANTAN BARAT' => ['KALIMANTAN BARAT'],
            'KALIMANTAN TENGAH' => ['KALIMANTAN TENGAH'],
            'KALIMANTAN SELATAN' => ['KALIMANTAN SELATAN'],
            'KALIMANTAN TIMUR' => ['KALIMANTAN TIMUR'],
            'KALIMANTAN UTARA' => ['KALIMANTAN UTARA'],
            'SULAWESI UTARA' => ['SULAWESI UTARA'],
            'SULAWESI TENGAH' => ['SULAWESI TENGAH'],
            'SULAWESI SELATAN' => ['SULAWESI SELATAN'],
            'SULAWESI TENGGARA' => ['SULAWESI TENGGARA'],
            'GORONTALO' => ['GORONTALO'],
            'SULAWESI BARAT' => ['SULAWESI BARAT'],
            'MALUKU' => ['MALUKU'],
            'MALUKU UTARA' => ['MALUKU UTARA'],
            'PAPUA' => ['PAPUA'],
            'PAPUA BARAT' => ['PAPUA BARAT'],
        ];

        $provinceUpper = strtoupper($provinceName);
        return $mapping[$provinceUpper] ?? [$provinceName];
    }
}
