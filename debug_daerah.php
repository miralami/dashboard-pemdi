<?php

use App\Models\SpbeData;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$daerahs = SpbeData::select('daerah')->distinct()->limit(20)->pluck('daerah');
foreach ($daerahs as $daerah) {
    echo $daerah . "\n";
}
