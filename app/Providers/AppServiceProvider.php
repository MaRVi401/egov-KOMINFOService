<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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