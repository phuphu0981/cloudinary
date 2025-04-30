<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cloudController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoverController;
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
Route::get('/upload', [cloudController::class, 'index']);
Route::post('/upload', [cloudController::class, 'upload'])->name('upload');
Route::get('/files', [FileController::class, 'index'])->name('files.index');
Route::post('/files/update/{publicId}', [FileController::class, 'update'])->name('files.update');
Route::delete('/files/delete/{publicId}', [FileController::class, 'destroy'])->name('files.destroy');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/lovers', [LoverController::class, 'index'])->name('lovers.index');
Route::post('/lovers', [LoverController::class, 'store'])->name('lovers.store');
Route::get('/lovers/{id}/edit', [LoverController::class, 'edit'])->name('lovers.edit');
Route::put('/lovers/{id}', [LoverController::class, 'update'])->name('lovers.update');
Route::delete('/lovers/{id}', [LoverController::class, 'destroy'])->name('lovers.destroy');
