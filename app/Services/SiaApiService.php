<?php

namespace App\Services;

use App\Models\SiaData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;

class SiaApiService
{
    /**
     * Fetch SIA data from API with caching
     * Cache is the primary source (15 min TTL), API is only called if cache misses
     *
     * @param string|null $instansiId Optional institution ID filter
     * @return array
     */
    public function getSiaData(?string $instansiId = null): array
    {
        // Cache key based on instansi ID - cache is primary source
        $cacheKey = 'sia_data' . ($instansiId ? "_{$instansiId}" : '_all');

        return Cache::remember($cacheKey, 900, function () use ($instansiId) {
            try {
                $apiUrl = env('SIA_API_URL');

                if (!$apiUrl) {
                    Log::warning('SIA_API_URL not configured, trying local file fallback');
                    return $this->getLocalSiaData();
                }

                // Add institution ID as query parameter if provided
                if ($instansiId) {
                    $apiUrl .= '?id_instansi=' . urlencode($instansiId);
                }

                $response = Http::timeout(5)->get($apiUrl);

                if ($response->successful()) {
                    $data = $response->json();
                    Log::info('SIA data fetched from API' . ($instansiId ? " for institution: {$instansiId}" : ''));
                    return $data;
                }

                throw new Exception('SIA API returned non-successful status: ' . $response->status());

            } catch (Exception $e) {
                Log::warning('Failed to fetch SIA data from API: ' . $e->getMessage() . ', trying local file fallback');
                return $this->getLocalSiaData();
            }
        });
    }

    /**
     * Fetch SIA data from API and store in database
     *
     * @return array
     */
    public function fetchAndStore(): array
    {
        try {
            $apiUrl = config('services.sia.api_url');
            $apiKey = config('services.sia.api_key');

            if (empty($apiUrl)) {
                throw new Exception('SIA API URL is not configured');
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'code' => $apiKey,
                    'Accept' => 'application/json',
                ])
                ->get($apiUrl);

            if ($response->successful()) {
                $data = $response->json();

                // Store all data in database
                $count = $this->storeData($data);

                Log::info('SIA data fetched and stored successfully', ['count' => $count]);

                return [
                    'success' => true,
                    'count' => $count,
                    'message' => 'Data fetched and stored successfully'
                ];
            }

            throw new Exception('API returned non-successful status: ' . $response->status());

        } catch (Exception $e) {
            Log::error('Failed to fetch SIA data from API: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Store API response data in database
     *
     * @param array $data
     * @return int Count of stored records
     */
    private function storeData(array $data): int
    {
        $count = 0;

        // Handle response structure with 'results' key
        $institutions = [];
        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $categoryData) {
                if (is_array($categoryData)) {
                    $institutions = array_merge($institutions, $categoryData);
                }
            }
        } else {
            $institutions = $data;
        }

        foreach ($institutions as $item) {
            SiaData::updateOrCreate(
                [
                    'instansi' => $item['instansi'],
                    'id_kategori_instansi' => $item['id_kategori_instansi'],
                ],
                [
                    'id_daerah' => $item['id_daerah'] ?? 0,
                    'tingkat_kematangan' => $item['tingkat_kematangan'] ?? null,
                    'proses_bisnis_as_is' => $item['proses_bisnis_as_is'] ?? 0,
                    'layanan_as_is' => $item['layanan_as_is'] ?? 0,
                    'data_info_as_is' => $item['data_info_as_is'] ?? 0,
                    'aplikasi_as_is' => $item['aplikasi_as_is'] ?? 0,
                    'infra_as_is' => $item['infra_as_is'] ?? 0,
                    'keamanan_as_is' => $item['keamanan_as_is'] ?? 0,
                    'proses_bisnis_to_be' => $item['proses_bisnis_to_be'] ?? 0,
                    'layanan_to_be' => $item['layanan_to_be'] ?? 0,
                    'data_info_to_be' => $item['data_info_to_be'] ?? 0,
                    'aplikasi_to_be' => $item['aplikasi_to_be'] ?? 0,
                    'infra_to_be' => $item['infra_to_be'] ?? 0,
                    'keamanan_to_be' => $item['keamanan_to_be'] ?? 0,
                    'peta_rencana' => $item['peta_rencana'] ?? false,
                    'clearance' => $item['clearance'] ?? false,
                    'reviueval' => $item['reviueval'] ?? false,
                ]
            );
            $count++;
        }

        return $count;
    }

    /**
     * Fetch SIA data for specific institution by name (from database)
     *
     * @param string $institutionName
     * @return array|null
     */
    public function getSiaDataByInstitutionName(string $institutionName): ?array
    {
        try {
            $record = SiaData::getByInstitutionName($institutionName);

            if (!$record) {
                Log::warning('No SIA data found in database for: ' . $institutionName);
                return null;
            }

            return $record->toArray();

        } catch (Exception $e) {
            Log::error('Failed to get SIA data by institution name: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch SIA data for specific institution by name with caching
     * This method caches the result per institution to avoid repeated searches
     *
     * @param string $institutionName
     * @param string|null $kode Optional institution code for better cache key
     * @return array|null
     */
    public function getSiaDataByInstitutionNameCached(string $institutionName, ?string $kode = null): ?array
    {
        // Use kode if available for better cache key, otherwise sanitize institution name
        $cacheKey = $kode
            ? "sia_institution_{$kode}"
            : 'sia_institution_' . md5($institutionName);

        return Cache::remember($cacheKey, 900, function () use ($institutionName) {
            return $this->getSiaDataByInstitutionName($institutionName);
        });
    }

    /**
     * Get SIA data from local file (for development/testing)
     *
     * @return array
     */
    private function getLocalSiaData(): array
    {
        try {
            // Try multiple locations
            $possiblePaths = [
                base_path('response-SIA.txt'),
                base_path('docs/response-SIA.txt'),
            ];

            $filePath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $filePath = $path;
                    break;
                }
            }

            if (!$filePath) {
                Log::warning('Local SIA data file not found in any location');
                return [];
            }

            $content = file_get_contents($filePath);
            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Failed to parse local SIA data: ' . json_last_error_msg());
                return [];
            }

            Log::info('SIA data loaded from local file: ' . $filePath);
            return $data;

        } catch (Exception $e) {
            Log::error('Failed to load local SIA data: ' . $e->getMessage());
            return [];
        }
    }
}
