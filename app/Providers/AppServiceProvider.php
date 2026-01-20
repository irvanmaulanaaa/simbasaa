<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Penarikan;
use App\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // if (config('app.env') === 'local') {
        //     URL::forceScheme('https');
        // }

        View::composer('layouts.navigation', function ($view) {
            $user = Auth::user();
            $showDot = false;

            if ($user) {
                if ($user->hasRole('ketua')) {
                    $showDot = Penarikan::where('status', 'pending')->exists();
                } elseif ($user->hasRole('warga')) {
 
                    $showDot = Penarikan::where('warga_id', $user->id_user)
                        ->where('status', 'ditolak')
                        ->where('is_read', 0)
                        ->exists();
                }
            }

            $view->with('showHamburgerDot', $showDot);
        });
    }
}
