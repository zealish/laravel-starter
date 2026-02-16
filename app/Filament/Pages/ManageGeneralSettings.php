<?php

namespace App\Filament\Pages;

use App\Core\FileFactory;
use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageGeneralSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static string $settings = GeneralSettings::class;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Identitas Website')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nama Website')
                            ->required(),
                        Textarea::make('site_description')
                            ->label('Deskripsi Global (SEO)')
                            ->required(),
                        FileFactory::optimizedImage('site_logo', 'settings')
                            ->label('Logo / OG Image'),
                        TextInput::make('seo_keywords')
                            ->label('Keywords Global'),
                        Textarea::make('google_analytics')
                            ->label('Google Analytics / Tracking Code')
                            ->placeholder('<script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXX"></script>...')
                            ->rows(5)
                            ->helperText('Tempelkan kode pelacakan lengkap dari Google Analytics atau GTM di sini.'),
                    ])
            ]);
    }
}
