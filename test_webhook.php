<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$response = \Illuminate\Support\Facades\Http::get('https://webhook.site/token/4772b7fa-2469-4c0c-b496-dfc8adb12b95/requests');
if ($response->successful()) {
    $requests = $response->json('data');
    if ($requests) {
        $latestPost = collect($requests)->where('method', 'POST')->sortByDesc('created_at')->first();
        if ($latestPost) {
            echo "Found POST!\n";
            print_r($latestPost['content']);
        } else {
            echo "No POST found\n";
        }
    } else {
        echo "No data found\n";
    }
} else {
    echo "Request failed: " . $response->status() . "\n";
}
