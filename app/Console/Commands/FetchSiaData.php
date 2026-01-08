<?php

namespace App\Console\Commands;

use App\Services\SiaApiService;
use Illuminate\Console\Command;

class FetchSiaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sia:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch SIA (Sistem Informasi Arsitektur) data from API and store in database';

    /**
     * Execute the console command.
     */
    public function handle(SiaApiService $siaService): int
    {
        $this->info('Fetching SIA data from API...');

        $result = $siaService->fetchAndStore();

        if ($result['success']) {
            $this->info("Success! {$result['count']} records stored/updated.");
            return Command::SUCCESS;
        }

        $this->error("Failed: {$result['message']}");
        return Command::FAILURE;
    }
}
