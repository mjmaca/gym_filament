<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Filament\Pages\CreateAttendance; // Make sure you're importing the correct class
use App\Filament\Pages\QRScanner; // Make sure you're importing the correct class

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/download-report', [ReportController::class, 'download'])->name('download.report');
    Route::get('/create-attendance', CreateAttendance::class)->name('filament.pages.create-attendance'); 
    Route::get('/q-r-scanner', QRScanner::class)->name('filament.pages.q-r-scanner');
});

