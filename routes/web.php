<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaAsn\ServiceController;
use App\Http\Controllers\PenggunaAsn\ServiceEmailGovController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevTemplateController;
use App\Http\Controllers\PenggunaAsn\ServiceSubDomainController;
use App\Http\Controllers\PenggunaAsn\ServiceAppsCreationController;
use App\Http\Controllers\PenggunaAsn\ServiceComplaintSystemController;
use App\Http\Controllers\PenggunaAsn\SubmissionController;
use App\Http\Controllers\PenggunaAsn\ServiceHistoryTicketController;
use App\Http\Controllers\Operator\TicketController as OperatorTicketController;

/*
|--------------------------------------------------------------------------
| Test Error Routes
|--------------------------------------------------------------------------
*/

Route::get('/error/{code}', function ($code) {
    abort($code);
});


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

    // Edit profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

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
    | Khusus Operator
    |----------------------------------------------------------------------
    */
    Route::middleware('can:operator-only')->group(function () {

        // Halaman Meja Kerja
        Route::get('workdesk', [OperatorTicketController::class, 'workDesk'])->name('ticket.workdesk');

        // Proses Ambil Tiket
        Route::post('ticket/{uuid}/handle', [OperatorTicketController::class, 'handle'])->name('ticket.handle');

        // Proses Selesaikan Tiket
        Route::resource('ticket', OperatorTicketController::class)
            ->parameters(['ticket' => 'uuid'])
            ->only(['index', 'show', 'update', 'destroy']);
    });

    /*
    |----------------------------------------------------------------------
    | Khusus pengguna asn
    |----------------------------------------------------------------------
    */

    Route::middleware('can:pengguna_asn-only')->group(function () {

        Route::resource('services', ServiceController::class);

        // RUTE UNTUK DOWNLOAD Email Gov
        Route::get('services/email-gov/download/{uuid}', [ServiceEmailGovController::class, 'download'])
            ->name('email.download');

        // Rute baru untuk Email E-Gov
        Route::resource('services-email-e-gov', ServiceEmailGovController::class);

        //Rute baru untuk Sub Domain
        Route::resource('service-sub-domain', ServiceSubDomainController::class);

        //RUTE DOWNLOAD SUBDOMAIN
        Route::get('services/subdomain/download/{uuid}', [ServiceSubDomainController::class, 'download'])
            ->name('subdomain.download');

        //Rute baru untuk Pembuatan Apps
        Route::get('/service-app-creation/download/{uuid}', [App\Http\Controllers\PenggunaAsn\ServiceAppsCreationController::class, 'download'])->name('appscreation.download');
        Route::resource('service-app-creation', ServiceAppsCreationController::class);


        //Rute untuk pengaduan
        Route::resource('service-complaint-system', ServiceComplaintSystemController::class);


        Route::prefix('dev')->group(function () {
            Route::get('/upload-template', [DevTemplateController::class, 'index'])->name('dev.template.index');
            Route::post('/upload-template', [DevTemplateController::class, 'store'])->name('dev.template.store');
        });

        //Rute Submission
        Route::post('/submission/{uuid}/upload', [SubmissionController::class, 'uploadDocument'])->name('submission.upload');
        Route::resource('submission', SubmissionController::class);

        //Rute History Tiket
        Route::resource('history', ServiceHistoryTicketController::class);
        
        //Rute Scanner Image
        Route::view('/ai-scanner', 'pages.pengguna-asn.layanan.test-scanner')->name('test.scanner');
    });
});

