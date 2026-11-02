<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MencobaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Pengalihan halaman utama ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Pertemuan 5: Controller & Migration
Route::get('/coba', [MencobaController::class, 'boomesport']);
Route::resource('/post', PostController::class);

// Pertemuan 1: Route dan View Sederhana
Route::get('/about', function () {
    return view('about');
})->name('about');

// Rute Autentikasi Tamu (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Rute Terproteksi Middleware 'auth' (Dapat diakses oleh level 'admin' dan 'user')
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Modul Data Buku (Pertemuan 8: Fitur Pelengkap CRUD)
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
    Route::post('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::post('/buku/delete/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
});

// Rute Terproteksi Middleware 'admin' (Hanya dapat diakses oleh pengguna level 'admin')
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class);
});
