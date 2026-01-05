<?php

namespace App\Services;

use App\Models\DashboardCache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class DashboardService
{
    /**
     * Fetch dashboard data from API or fallback to database
     *
     * @return array
     */
    public function getDashboardData(): array
    {
        try {
            // Attempt to fetch from API
            $apiUrl = env('DASHBOARD_API_URL', 'https://api.example.com/dashboard-data');

            $response = Http::timeout(5)->get($apiUrl);

            if ($response->successful()) {
                $data = $response->json();

                // Store/update in database for future fallback
                DashboardCache::updateOrCreate(
                    ['key' => 'dashboard_data'],
                    ['json_data' => $data]
                );

                Log::info('Dashboard data fetched from API successfully');

                return $data;
            }

            // If response not successful, throw exception to trigger fallback
            throw new Exception('API returned non-successful status: ' . $response->status());

        } catch (Exception $e) {
            // Log the error
            Log::warning('Failed to fetch dashboard data from API: ' . $e->getMessage());

            // Fallback to database
            return $this->getFromDatabase();
        }
    }

    /**
     * Get dashboard data from database
     *
     * @return array
     */
    private function getFromDatabase(): array
    {
        $cache = DashboardCache::where('key', 'dashboard_data')->first();

        if ($cache) {
            Log::info('Dashboard data fetched from database (fallback)');
            return $cache->json_data;
        }

        // If nothing in database, return empty structure
        Log::error('No dashboard data found in database');
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
}
