<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaAsn\ServiceController;
use App\Http\Controllers\PenggunaAsn\ServiceEmailGovController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevTemplateController;




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
    Route::get('/dashboard', [DashboardController::class, 'index'])
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
        
    //User management
        Route::resource('user-management', UserManagementController::class)
            ->names('user-management')
            ->parameters(['user-management' => 'user']);
    });

    /*
    |----------------------------------------------------------------------
    | Khusus pengguna asn
    |----------------------------------------------------------------------
    */

    Route::middleware('can:pengguna_asn')->group(function () {
        
        Route::resource('services', ServiceController::class)
            ->names(['index' => 'services.index']);

        // RUTE UNTUK DOWNLOAD 
        Route::get('services/email-gov/download/{uuid}', [ServiceEmailGovController::class, 'download'])
        ->name('email.download');

        // Rute baru untuk Email E-Gov
        Route::resource('services-email-e-gov', ServiceEmailGovController::class)
            ->names([
                'index' => 'email.index',
                'store' => 'email.store'
            ]);

        Route::prefix('dev')->group(function () {
            Route::get('/upload-template', [DevTemplateController::class, 'index'])->name('dev.template.index');
            Route::post('/upload-template', [DevTemplateController::class, 'store'])->name('dev.template.store');
        });

    });
    
    
    
});
