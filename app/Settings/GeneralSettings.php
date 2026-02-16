<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public string $site_description;
    public ?string $site_logo;
    public string $seo_keywords;
    public ?string $google_analytics;
    public ?string $analytics_property_id;

    public static function group(): string
    {
        return 'general';
    }
}
