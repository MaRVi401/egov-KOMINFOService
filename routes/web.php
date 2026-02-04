<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


// Halaman utama (Login)
Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// Proses Post Login
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');


// Proteksi Route berdasarkan Auth
Route::middleware(['auth'])->group(function () {

    // Dashboard Super Admin
    Route::get('/super-admin/dashboard', function () {
        return view('pages.super-admin.dashboard');
    })->name('super-admin.dashboard');

    // Dashboard ASN
    Route::get('/asn/dashboard', function () {
        return view('pages.pengguna-asn.dashboard');
    })->name('asn.dashboard');

    // Dashboard Kabid
    Route::get('/kabid/dashboard', function () {
        return view('pages.kabid.dashboard');
    })->name('kabid.dashboard');

    // Dashboard Operator
    Route::get('/operator/dashboard', function () {
        return view('pages.operator.dashboard');
    })->name('operator.dashboard');

    // Proses Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
