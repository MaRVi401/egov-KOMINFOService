<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Guest Routes (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Halaman Login
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    // Proses Login
    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.post');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Sudah Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

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
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});
