<?php

namespace App\Services;

use App\Models\DashboardCache;
use App\Models\SpbeData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;

class DashboardService
{
    protected $siaApiService;

    public function __construct(SiaApiService $siaApiService)
    {
        $this->siaApiService = $siaApiService;
    }

    /**
     * TAUVAL Domain mapping - Based on D codes from TAUVAL response
     */
    private const DOMAIN_MAPPING = [
        [
            'name' => 'Kebijakan SPBE',
            'tauval_key' => 'D2001',
        ],
        [
            'name' => 'Tata Kelola SPBE',
            'tauval_key' => 'D2002',
        ],
        [
            'name' => 'Manajemen SPBE',
            'tauval_key' => 'D2003',
        ],
        [
            'name' => 'Layanan SPBE',
            'tauval_key' => 'D2004',
        ],
    ];

    /**
     * Detailed domain breakdown
     */
    private const DETAILED_DOMAINS = [
        1 => 'Kebijakan SPBE',
        2 => 'Tata Kelola SPBE',
        3 => 'Manajemen SPBE',
        4 => 'Layanan SPBE',
    ];

    /**
     * Fetch dashboard data from database (prioritized) with API fallback
     * Database is updated daily, so it's the primary source
     * Implements aggressive caching for performance
     *
     * @param string|null $kode Institution code
     * @return array
     */
    public function getDashboardData(?string $kode = null): array
    {
        // Check cache first (5 minutes TTL)
        $cacheKey = $kode ? "dashboard_data_{$kode}" : 'dashboard_data';

        return Cache::remember($cacheKey, 300, function () use ($kode, $cacheKey) {
            // Priority 1: Fetch from database (updated daily)
            $data = $this->getFromDatabase($kode);

            if (!empty($data)) {
                Log::info('Dashboard data fetched from database (primary source)' . ($kode ? " for institution: {$kode}" : ''));
                return $data;
            }

            // Priority 2: Fallback to API only if database has no data
            try {
                $apiUrl = env('DASHBOARD_API_URL');

                if (!$apiUrl) {
                    Log::warning('No dashboard data in database and no API configured');
                    return [];
                }

                // Add kode as query parameter if provided
                if ($kode) {
                    $apiUrl .= '?kode=' . urlencode($kode);
                }

                $response = Http::timeout(3)->get($apiUrl);

                if ($response->successful()) {
                    $data = $response->json();

                    // Store in database for future use
                    DashboardCache::updateOrCreate(
                        ['key' => $cacheKey],
                        ['json_data' => $data]
                    );

                    Log::info('Dashboard data fetched from API (fallback)' . ($kode ? " for institution: {$kode}" : ''));

                    return $data;
                }

                throw new Exception('API returned non-successful status: ' . $response->status());

            } catch (Exception $e) {
                Log::error('Failed to fetch dashboard data from both database and API: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get dashboard data from database
     * This is now the primary data source
     *
     * @param string|null $kode Institution code
     * @return array
     */
    private function getFromDatabase(?string $kode = null): array
    {
        // First try dashboard_cache table
        $cacheKey = $kode ? "dashboard_data_{$kode}" : 'dashboard_data';
        $cache = DashboardCache::where('key', $cacheKey)->first();

        if ($cache) {
            return $cache->json_data;
        }

        // Try to build from spbe_data table (primary data source)
        if ($kode) {
            $spbeData = SpbeData::getLatestByKode($kode);

            if ($spbeData) {

                $nilai = $spbeData->nilai ?? [];
                $indeks = (float) $spbeData->indeks;

                // Get historical data for trend (2019-2024) - cached
                $trendData = $this->getSpbeTrendData($kode);

                // Build implementation index chart from TAUVAL data (D2001-D2004)
                $architectureChart = $this->buildArchitectureChartFromTauval($nilai, $spbeData->tahun);

                // Calculate budget data from clearance table
                $budgetData = $this->calculateBudgetData($spbeData->nama_instansi);

                // Build dashboard structure from spbe_data
                return [
                    'profile' => [
                        'name' => $spbeData->nama_instansi,
                        'minister' => $spbeData->kategori ?? '-',
                        'kode' => $spbeData->kode,
                    ],
                    'spbeIndex' => [
                        'value' => $indeks,
                        'label' => $this->getIndeksLabel($indeks),
                        'current' => $indeks,
                        'previous' => 0,
                        'change' => 0,
                    ],
                    'totalApplications' => [
                        'value' => 0,
                        'new' => 0,
                    ],
                    'governanceStatus' => [],
                    'recommendations' => [],
                    'domainChanges' => [],
                    'implementationIndex' => $architectureChart,
                    'spbeTrend' => $trendData,
                    'pemdiTrend' => [
                        'labels' => [],
                        'datasets' => [],
                    ],
                    'budget' => $budgetData,
                    'nilai' => $nilai,
                    'tahun' => $spbeData->tahun,
                ];
            }
        }

        // No data found in database - caller will try API fallback if needed
        return [];
    }

    /**
     * Force refresh data from database only
     *
     * @return array
     */
    public function getFromDatabaseOnly(): array
    {
        return $this->getFromDatabase();
    }

    /**
     * Get index label based on value
     *
     * @param float $indeks
     * @return string
     */
    private function getIndeksLabel(float $indeks): string
    {
        if ($indeks >= 4.5) return 'Sangat Baik';
        if ($indeks >= 3.5) return 'Baik';
        if ($indeks >= 2.5) return 'Cukup';
        if ($indeks >= 1.5) return 'Kurang';
        return 'Sangat Kurang';
    }

    /**
     * Get SPBE trend data from 2019 to 2024
     * Optimized with single queries and caching
     *
     * @param string $kode
     * @return array
     */
    private function getSpbeTrendData(string $kode): array
    {
        // Cache for 10 minutes
        return Cache::remember("spbe_trend_{$kode}", 600, function () use ($kode) {
            // Get all distinct years from the database, ordered chronologically
            $years = SpbeData::distinct()
                ->orderBy('tahun')
                ->pluck('tahun')
                ->toArray();

            // Fetch all institution data in one query
            $institutionData = SpbeData::where('kode', $kode)
                ->whereIn('tahun', $years)
                ->orderBy('tahun')
                ->get()
                ->keyBy('tahun');

            // Calculate national averages in one query
            $nationalData = SpbeData::selectRaw('tahun, AVG(indeks) as avg_indeks')
                ->whereIn('tahun', $years)
                ->groupBy('tahun')
                ->orderBy('tahun')
                ->pluck('avg_indeks', 'tahun');

            $institutionValues = [];
            $nationalValues = [];

            // Build the data arrays
            foreach ($years as $year) {
                $institutionValues[] = isset($institutionData[$year]) ? (float) $institutionData[$year]->indeks : 0;
                $nationalValues[] = isset($nationalData[$year]) ? (float) $nationalData[$year] : 0;
            }

            return [
                'labels' => $years,
                'datasets' => [
                    [
                        'label' => 'Indeks SPBE',
                        'data' => $institutionValues,
                        'borderColor' => 'rgb(37, 92, 153)',
                        'backgroundColor' => 'rgba(37, 92, 153, 0.2)',
                        'fill' => true,
                        'tension' => 0.4,
                    ],
                    [
                        'label' => 'Nasional',
                        'data' => $nationalValues,
                        'borderColor' => 'rgb(234, 179, 8)',
                        'backgroundColor' => 'rgba(234, 179, 8, 0.2)',
                        'fill' => true,
                        'tension' => 0.4,
                    ]
                ]
            ];
        });
    }

    /**
     * Build implementation index chart from TAUVAL data (D2001-D2004)
     * Includes institution values and national average
     *
     * @param array $nilai Array containing D2001-D2004 values from TAUVAL
     * @param string|null $tahun Year for national average calculation
     * @return array Chart data for SPBE implementation index (radar chart)
     */
    private function buildArchitectureChartFromTauval(array $nilai, ?string $tahun = null): array
    {
        // Get national averages for each domain
        $nationalAverages = $this->getNationalAveragesByDomain($tahun);

        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Instansi',
                    'data' => [],
                    'backgroundColor' => 'rgba(234, 179, 8, 0.5)',
                    'borderColor' => 'rgb(234, 179, 8)',
                    'borderWidth' => 2,
                    'pointBackgroundColor' => 'rgb(234, 179, 8)',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgb(234, 179, 8)',
                ],
                [
                    'label' => 'Nasional',
                    'data' => [],
                    'backgroundColor' => 'rgba(37, 92, 153, 0.5)',
                    'borderColor' => 'rgb(37, 92, 153)',
                    'borderWidth' => 2,
                    'pointBackgroundColor' => 'rgb(37, 92, 153)',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgb(37, 92, 153)',
                ]
            ]
        ];

        // Process each domain from TAUVAL (D2001-D2004)
        foreach (self::DOMAIN_MAPPING as $domainInfo) {
            $chartData['labels'][] = $domainInfo['name'];

            // Get institution value from nilai array (D2001, D2002, D2003, D2004)
            $institutionValue = isset($nilai[$domainInfo['tauval_key']])
                ? (float) $nilai[$domainInfo['tauval_key']]
                : 0;

            // Get national average for this domain
            $nationalValue = $nationalAverages[$domainInfo['tauval_key']] ?? 0;

            $chartData['datasets'][0]['data'][] = $institutionValue;
            $chartData['datasets'][1]['data'][] = $nationalValue;
        }

        return $chartData;
    }

    /**
     * Get national averages for each domain (D2001-D2004)
     *
     * @param string|null $tahun Year to calculate averages for (null = latest year)
     * @return array
     */
    private function getNationalAveragesByDomain(?string $tahun = null): array
    {
        // Use cache to avoid repeated queries
        $cacheKey = 'national_domain_avg_' . ($tahun ?? 'latest');

        return Cache::remember($cacheKey, 600, function () use ($tahun) {
            // If no year specified, get latest year
            if (!$tahun) {
                $tahun = SpbeData::max('tahun');
            }

            // Get all records for the specified year
            $records = SpbeData::where('tahun', $tahun)
                ->whereNotNull('nilai')
                ->get();

            if ($records->isEmpty()) {
                return [
                    'D2001' => 0,
                    'D2002' => 0,
                    'D2003' => 0,
                    'D2004' => 0,
                ];
            }

            // Calculate averages for each domain
            $domainSums = [
                'D2001' => 0,
                'D2002' => 0,
                'D2003' => 0,
                'D2004' => 0,
            ];
            $count = 0;

            foreach ($records as $record) {
                $nilai = $record->nilai;
                if (is_array($nilai)) {
                    foreach ($domainSums as $key => $value) {
                        if (isset($nilai[$key])) {
                            $domainSums[$key] += (float) $nilai[$key];
                        }
                    }
                    $count++;
                }
            }

            // Calculate averages
            $averages = [];
            foreach ($domainSums as $key => $sum) {
                $averages[$key] = $count > 0 ? round($sum / $count, 2) : 0;
            }

            return $averages;
        });
    }

    /**
     * Calculate budget data from clearance table
     * Logic: Find institution name, sum all its budget entries
     * First record initializes the total, subsequent records add (Dilanjutkan) or subtract (Tidak Dilanjutkan)
     *
     * @param string $institutionName
     * @return array
     */
    private function calculateBudgetData(string $institutionName): array
    {
        // Get all clearance records for this institution
        $clearanceRecords = \DB::table('clearance')
            ->where('instansi', $institutionName)
            ->orderBy('id')
            ->get();

        if ($clearanceRecords->isEmpty()) {
            return [
                'labels' => [],
                'datasets' => [],
            ];
        }

        $anggaranTotal = 0;
        $anggaranDisetujui = 0;
        $anggaranDitunda = 0;

        foreach ($clearanceRecords as $record) {
            $anggaran = (int) $record->anggaran;

            // Total is sum of all budgets submitted
            $anggaranTotal += $anggaran;

            // Categorize by recommendation
            if ($record->rekomendasi === 'Dilanjutkan') {
                $anggaranDisetujui += $anggaran;
            } else {
                $anggaranDitunda += $anggaran;
            }
        }

        // Convert to millions for display
        $anggaranTotalM = round($anggaranTotal / 1000000, 2);
        $anggaranDisetujuiM = round($anggaranDisetujui / 1000000, 2);
        $anggaranDitundaM = round($anggaranDitunda / 1000000, 2);

        return [
            'labels' => ['Total', 'Disetujui', 'Ditunda'],
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => [$anggaranTotalM, 0, 0],
                ],
                [
                    'label' => 'Disetujui',
                    'data' => [0, $anggaranDisetujuiM, 0],
                ],
                [
                    'label' => 'Ditunda',
                    'data' => [0, 0, $anggaranDitundaM],
                ],
            ],
        ];
    }
}
