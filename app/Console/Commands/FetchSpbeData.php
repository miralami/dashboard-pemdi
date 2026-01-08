<?php

namespace App\Console\Commands;

use App\Services\SpbeApiService;
use Illuminate\Console\Command;

class FetchSpbeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spbe:fetch {--awal= : Starting year (optional)} {--akhir= : Ending year (optional)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch SPBE data from API and store in database. Use --awal and --akhir to specify year range.';

    /**
     * Execute the console command.
     */
    public function handle(SpbeApiService $spbeService): int
    {
        $awal = $this->option('awal') ? (int) $this->option('awal') : null;
        $akhir = $this->option('akhir') ? (int) $this->option('akhir') : null;

        if ($awal || $akhir) {
            $this->info("Fetching SPBE data from API (Year: {$awal} to {$akhir})...");
        } else {
            $this->info('Fetching SPBE data from API (all years from 2020)...');
        }

        $result = $spbeService->fetchAndStore($awal, $akhir);

        if ($result['success']) {
            $this->info("Success! {$result['count']} records stored/updated.");
            return Command::SUCCESS;
        }

        $this->error("Failed: {$result['message']}");
        return Command::FAILURE;
    }
}
