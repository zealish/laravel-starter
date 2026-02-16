<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Settings\GeneralSettings;

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
    public function boot(GeneralSettings $settings): void
    {
        // Override Config SEOTools secara dinamis dari Class Settings
        Config::set('seotools.meta.defaults.title', $settings->site_name);
        Config::set('seotools.meta.defaults.description', $settings->site_description);
        Config::set('seotools.meta.defaults.keywords', [$settings->seo_keywords]);
        Config::set('analytics.property_id', [$settings->analytics_property_id]);

        if ($settings->site_logo) {
            $logoUrl = asset('storage/' . $settings->site_logo);
            Config::set('seotools.meta.defaults.image', [$logoUrl]);
            Config::set('seotools.opengraph.defaults.images', [$logoUrl]);
        }
    }
}
