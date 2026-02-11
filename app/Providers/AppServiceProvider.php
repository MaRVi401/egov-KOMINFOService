<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate untuk Middleware 'can:super-admin-only'
        Gate::define('super-admin-only', function (User $user) {
            return $user->role === 'super_admin';
        });

        // Gate untuk Middleware 'can:pengguna_asn
        Gate::define('pengguna_asn', function (User $user) {
            return $user->role === 'pengguna_asn'; 
        });
        // View Composer hanya berjalan saat view 'partials.dashboard.sidebar' dipanggil
        View::composer('partials.dashboard.sidebar', function ($view) {
            
            // Mengambil file JSON
            $path = resource_path('json/menu.json');
            $menuData = json_decode(file_get_contents($path), true);
            
            // Gunakan Auth::user() yang lebih eksplisit
            $user = Auth::user(); 
            $userRole = $user ? $user->role : null;

            // Cari menu yang sesuai dengan role
            $filteredMenu = collect($menuData['menu'])->firstWhere('role', $userRole);

            // Kirim data ke view
            $view->with('verticalMenu', $filteredMenu['items'] ?? []);
        });
    }
}