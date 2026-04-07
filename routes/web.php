<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Test upload
Route::view('/charter', 'charter')->name('charter');
Route::view('/legal', 'legal')->name('legal');
Route::view('/roadmap', 'roadmap')->name('roadmap');

Route::get('/actes/{acte}/pdf', [App\Http\Controllers\ActeController::class, 'downloadPdf'])->name('actes.pdf');
