<?php

use App\Http\Controllers\MencobaController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Pemanggilan method controller seperti pada modul (Laravel 9+)
Route::get('/coba', [MencobaController::class, 'boomesport']);

// Resource route untuk PostController (hasil dari php artisan make:controller PostController --resource)
Route::resource('/post', PostController::class);
