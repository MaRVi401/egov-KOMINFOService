<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProfileController;

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

    // Dashboard All Roles
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    // edit profile
    Route::middleware(['auth'])->group(function () {
        
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Proses Logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    /*
    |----------------------------------------------------------------------
    | Khusus Super Admin
    |----------------------------------------------------------------------
    */
    Route::middleware('can:super-admin-only')->group(function () {
        Route::resource('user-management', UserManagementController::class)
            ->names('user-management')
            ->parameters(['user-management' => 'user']);
    });
});
