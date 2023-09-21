<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('signed')->controller(FilesController::class)->group(function () {
    Route::get('/files/{file:code}/download', 'downloadForm')->name('files.downloadForm');
    Route::get('/files/download/{file}', 'download')->name('files.download');
});

Route::get('/files/{file:code}/preview/{filename}', [FilesController::class, 'showFile'])->name('files.show-file');
Route::get('/files/all_files/', [FilesController::class, 'showAll'])->name('files.show-all');
Route::get('/files/all_files/{file}/show', [FilesController::class, 'show_file'])->name('files.show_file');
Route::resource('/files', FilesController::class)->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
