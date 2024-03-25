<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendataanController;

Route::view('/', 'welcome');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified','admin'])
    ->name('dashboard');

Route::view('admin', 'admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin');

Route::view('petugas', 'petugas')
    ->middleware(['auth', 'verified', 'petugas'])
    ->name('petugas');

Route::view('pelanggan', 'pelanggan')
    ->middleware(['auth', 'verified', 'pelanggan'])
    ->name('pelanggan');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/pendataan', [PendataanController::class, 'index']);
Route::resource('pendataan', PendataanController::class);


require __DIR__.'/auth.php';
