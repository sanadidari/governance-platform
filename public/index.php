<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// FORCE SUBDIRECTORY FOR HOSTPAPA
$prefix = '/testftp/gov';
$_SERVER['SCRIPT_NAME'] = $prefix . '/index.php';
$_SERVER['PHP_SELF'] = $prefix . '/index.php';

// Fix REQUEST_URI to ensure Laravel routing works within the subdirectory
if (strpos($_SERVER['REQUEST_URI'], $prefix) !== 0) {
    $_SERVER['REQUEST_URI'] = $prefix . '/' . ltrim($_SERVER['REQUEST_URI'], '/');
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$request = Request::capture();

$app->handleRequest($request);
