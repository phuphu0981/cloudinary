<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cloudController;
use App\Http\Controllers\FileController;
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
