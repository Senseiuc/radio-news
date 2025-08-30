<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = Cache::remember('site_settings', 600, function () {
                return SiteSetting::query()->first();
            });

            // Share active ads grouped by placement (cached)
            $adsByPlacement = Cache::remember('ads_by_placement', 300, function () {
                return Ad::query()
                    ->where('is_active', true)
                    ->get()
                    ->groupBy('placement');
            });

            $adsenseClient = config('services.adsense.client', env('ADSENSE_CLIENT'));

            $view->with('siteSettings', $settings)
                 ->with('adsByPlacement', $adsByPlacement)
                 ->with('adsenseClient', $adsenseClient);
        });
    }
}
