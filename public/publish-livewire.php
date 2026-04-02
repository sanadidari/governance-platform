<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$app->instance('request', $request);

use Illuminate\Support\Facades\Artisan;
echo "<h1>Publishing Livewire Assets...</h1>";

try {
    Artisan::call('livewire:publish', ['--assets' => true]);
    echo "<pre>" . Artisan::output() . "</pre>";
    echo "<p style='color:green'>Success!</p>";
} catch (\Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
echo "<p>Next: Check if 'public/livewire/' directory exists on server.</p>";
