<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$app->instance('request', $request);

echo "<h1>Master Reset & Diagnostic</h1>";

// 1. Clear bootstrap/cache
echo "<h3>1. Cleaning bootstrap/cache...</h3>";
$cachePath = base_path('bootstrap/cache');
if (File::isDirectory($cachePath)) {
    foreach (File::files($cachePath) as $file) {
        if ($file->getExtension() === 'php') {
            if (File::delete($file)) {
                echo "Deleted: " . $file->getFilename() . "<br>";
            } else {
                echo "<span style='color:red'>Failed to delete: " . $file->getFilename() . "</span><br>";
            }
        }
    }
}

// 2. Clear storage/framework
echo "<h3>2. Cleaning storage/framework...</h3>";
$paths = [
    storage_path('framework/views'),
    storage_path('framework/cache/data'),
    storage_path('framework/sessions'),
];
foreach ($paths as $path) {
    if (File::isDirectory($path)) {
        File::cleanDirectory($path);
        echo "Cleaned: $path <br>";
    }
}

// 3. Force Artisan Clear
echo "<h3>3. Running Artisan Clears...</h3>";
try {
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    echo "<pre>" . Artisan::output() . "</pre>";
    echo "<span style='color:green'>Artisan clears successful!</span><br>";
} catch (\Exception $e) {
    echo "<span style='color:orange'>Artisan notice: " . $e->getMessage() . "</span><br>";
}

// 4. Diagnostic
echo "<h3>4. Environment Diagnostic</h3>";
echo "<b>APP_URL:</b> " . config('app.url') . "<br>";
echo "<b>Base Path:</b> " . base_path() . "<br>";
echo "<b>Public Path:</b> " . public_path() . "<br>";
echo "<b>Requested URI:</b> " . $_SERVER['REQUEST_URI'] . "<br>";
echo "<b>Script Name:</b> " . $_SERVER['SCRIPT_NAME'] . "<br>";

echo "<hr><p style='color:blue'><b>TENTATIVE DE RÉPARATION TERMINÉE.</b><br>Essayez de vous connecter maintenant.</p>";
