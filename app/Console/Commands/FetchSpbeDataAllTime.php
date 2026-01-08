<?php

namespace App\Console\Commands;

use App\Services\SpbeApiService;
use Illuminate\Console\Command;

class FetchSpbeDataAllTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spbe:fetchalltime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all SPBE data from 2019 to 2024 (year by year)';

    /**
     * Execute the console command.
     */
    public function handle(SpbeApiService $spbeService): int
    {
        $startYear = 2019;
        $endYear = 2024;

        $this->info("Fetching SPBE data from {$startYear} to {$endYear} (year by year)...");

        $totalRecords = 0;
        $failedYears = [];

        for ($year = $startYear; $year <= $endYear; $year++) {
            $this->info("Fetching data for year {$year}...");

            $result = $spbeService->fetchAndStore($year, $year);

            if ($result['success']) {
                $totalRecords += $result['count'];
                $this->info("  ✓ Year {$year}: {$result['count']} records stored/updated.");
            } else {
                $failedYears[] = $year;
                $this->error("  ✗ Year {$year} failed: {$result['message']}");
            }
        }

        if (empty($failedYears)) {
            $this->info("\nSuccess! Total {$totalRecords} records stored/updated across all years.");
            return Command::SUCCESS;
        }

        $this->warn("\nPartially completed. Failed years: " . implode(', ', $failedYears));
        $this->info("Successfully stored {$totalRecords} records from other years.");
        return Command::FAILURE;
    }
}
