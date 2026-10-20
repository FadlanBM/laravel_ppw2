<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MencobaController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/buku');
});

// Pertemuan 5: Controller & Migration
Route::get('/coba', [MencobaController::class, 'boomesport']);
Route::resource('/post', PostController::class);

// Pertemuan 1: Route dan View Sederhana
Route::get('/about', function () {
    return view('about');
})->name('about');

// Pertemuan 1: Autentikasi Pengguna (Login, Register, Logout, Dashboard)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Pertemuan 6: Fitur Pelengkap CRUD
Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
Route::post('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::post('/buku/delete/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
