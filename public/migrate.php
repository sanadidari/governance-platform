<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$app->instance('request', $request);

echo "<h1>Laravel Migration Running...</h1>";

try {
    // Run the migrations
    Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . Artisan::output() . "</pre>";
    echo "<p style='color:green'>Migrations completed successfully!</p>";
} catch (\Exception $e) {
    echo "<p style='color:red'>Error running migrations: " . $e->getMessage() . "</p>";
}

try {
    // Clear cache
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    echo "<p style='color:blue'>Caches cleared!</p>";
} catch (\Exception $e) {
    echo "<p style='color:orange'>Notice: Could not clear some caches via Artisan, please delete bootstrap/cache contents manually.</p>";
}

echo "<hr><p><b>IMPORTANT: Delete this file (public/migrate.php) from your server now!</b></p>";
