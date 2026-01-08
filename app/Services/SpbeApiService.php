<?php

namespace App\Services;

use App\Models\SpbeData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SpbeApiService
{
    /**
     * Fetch SPBE data from API and store in database
     *
     * @param int|null $awal Starting year (optional, defaults to 2020 if not provided)
     * @param int|null $akhir Ending year (optional, defaults to current year if not provided)
     * @return array
     */
    public function fetchAndStore(?int $awal = null, ?int $akhir = null): array
    {
        try {
            $apiUrl = config('services.spbe.api_url');
            $apiKey = config('services.spbe.api_key');

            if (empty($apiKey)) {
                throw new Exception('SPBE API key is not configured');
            }

            // Build query parameters
            $params = [];
            if ($awal !== null) {
                $params['awal'] = $awal;
            }
            if ($akhir !== null) {
                $params['akhir'] = $akhir;
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'code' => $apiKey,
                    'Accept' => 'application/json',
                ])
                ->get($apiUrl, $params);

            if ($response->successful()) {
                $data = $response->json();

                // Store all data in database
                $this->storeData($data);

                Log::info('SPBE data fetched and stored successfully', [
                    'count' => count($data),
                    'awal' => $awal,
                    'akhir' => $akhir
                ]);

                return [
                    'success' => true,
                    'count' => count($data),
                    'message' => 'Data fetched and stored successfully'
                ];
            }

            throw new Exception('API returned non-successful status: ' . $response->status());

        } catch (Exception $e) {
            Log::error('Failed to fetch SPBE data from API: ' . $e->getMessage());

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
     * @return void
     */
    private function storeData(array $data): void
    {
        foreach ($data as $item) {
            $indeks = $item['nilai']['indeks'] ?? null;

            SpbeData::updateOrCreate(
                [
                    'kode' => $item['kode'],
                    'tahun' => $item['tahun'],
                ],
                [
                    'nama_instansi' => $item['nama_instansi'],
                    'kategori' => $item['kategori'] ?? null,
                    'daerah' => $item['daerah'] ?? null,
                    'nilai' => $item['nilai'] ?? null,
                    'indeks' => $indeks ? (float) $indeks : null,
                ]
            );
        }
    }

    /**
     * Get data for frontend (id, nama_instansi, indeks only)
     *
     * @param string|null $kode Filter by specific kode
     * @return array
     */
    public function getForFrontend(?string $kode = null): array
    {
        if ($kode) {
            $record = SpbeData::getLatestByKode($kode);
            return $record ? $record->toFrontendArray() : [];
        }

        return SpbeData::getLatestYear()
            ->map(fn($item) => $item->toFrontendArray())
            ->toArray();
    }

    /**
     * Get single instansi data for frontend
     *
     * @param string $kode
     * @return array|null
     */
    public function getInstansiData(string $kode): ?array
    {
        $record = SpbeData::getLatestByKode($kode);

        if (!$record) {
            return null;
        }

        return $record->toFrontendArray();
    }

    /**
     * Get all data from database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllFromDatabase()
    {
        return SpbeData::all();
    }
}
