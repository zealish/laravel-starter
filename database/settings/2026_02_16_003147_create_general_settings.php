<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Zealish Starter');
        $this->migrator->add('general.site_description', 'Pusat informasi dan artikel terbaru.');
        $this->migrator->add('general.site_logo', null);
        $this->migrator->add('general.seo_keywords', 'laravel, blog, starter');
        $this->migrator->add('general.google_analytics', null);
    }

    public function down(): void
    {
        // Menghapus key spesifik dari grup 'general'
        $this->migrator->delete('general.site_name');
        $this->migrator->delete('general.site_description');
        $this->migrator->delete('general.site_logo');
        $this->migrator->delete('general.seo_keywords');
        $this->migrator->delete('general.google_analytics');
    }
};
