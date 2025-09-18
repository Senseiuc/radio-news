<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = null;
            if (Schema::hasTable('site_settings')) {
                $settings = Cache::remember('site_settings', 600, function () {
                    return SiteSetting::query()->first();
                });
            }

            // Share active ads grouped by placement (cached)
            $adsByPlacement = collect();
            if (Schema::hasTable('ads')) {
                $adsByPlacement = Cache::remember('ads_by_placement', 300, function () {
                    return Ad::query()
                        ->where('is_active', true)
                        ->get()
                        ->groupBy('placement');
                });
            }

            $adsenseClient = config('services.adsense.client', env('ADSENSE_CLIENT'));

            // Share globally so tests can access via View::shared()
            View::share('siteSettings', $settings);
            View::share('adsByPlacement', $adsByPlacement);
            View::share('adsenseClient', $adsenseClient);

            // Also attach to the current view instance
            $view->with('siteSettings', $settings)
                 ->with('adsByPlacement', $adsByPlacement)
                 ->with('adsenseClient', $adsenseClient);
        });
        Schema::defaultStringLength(191);
    }
}
