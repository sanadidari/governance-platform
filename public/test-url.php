<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$app->instance('request', $request);

echo "<h1>URL Diagnostic</h1>";
echo "<b>APP_URL in config:</b> " . config('app.url') . "<br>";
echo "<b>Forced Root URL:</b> " . url('/') . "<br>";
echo "<b>Portal Login Route:</b> " . route('filament.portal.auth.login') . "<br>";
echo "<b>Request URI:</b> " . $_SERVER['REQUEST_URI'] . "<br>";
echo "<b>Script Name:</b> " . $_SERVER['SCRIPT_NAME'] . "<br>";

echo "<h2>Manual AppServiceProvider Check</h2>";
$rootUrl = rtrim(config('app.url'), '/');
echo "<b>Cleaned Root URL:</b> $rootUrl <br>";
$path = parse_url($rootUrl, PHP_URL_PATH);
echo "<b>Parsed Path:</b> $path <br>";
$prefix = trim($path, '/');
echo "<b>Final Prefix for Livewire:</b> $prefix <br>";
