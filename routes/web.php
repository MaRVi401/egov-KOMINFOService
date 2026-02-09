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

// // Test Page
// Route::get('/test', function () {
//     return view('pages.super-admin.dashboard');
// })->name('dashboard');

// Route::get('/permohonan', function () {
//     return view('pages.super-admin.permohonan');
// })->name('permohonan');
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

    // Dashboard All Roles
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/roles-management', function () {
        return view('pages.super-admin.roles-management.index');
    })->name('roles-management');


    // Proses Logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});
