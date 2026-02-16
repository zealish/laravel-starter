<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Storage;

class OverviewStats extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // 1. Kalkulasi Storage (Estimasi Folder Public)
        $storageSize = 0;
        foreach (Storage::disk('public')->allFiles('posts') as $file) {
            $storageSize += Storage::disk('public')->size($file);
        }
        $formattedSize = round($storageSize / 1024 / 1024, 2) . ' MB';

        // 2. Hitung Total Draft & Published
        $totalPublished = Post::where('is_published', true)->count();
        $totalDraft = Post::where('is_published', false)->count();

        return [
            Stat::make('Storage Artikel', $formattedSize)
                ->description('Total gambar di folder posts')
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color($storageSize > 500 * 1024 * 1024 ? 'danger' : 'success'), // Alert jika > 500MB

            Stat::make('Status Cache', 'Active')
                ->description('Global Cache Sistem')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('info'),

            Stat::make('Artikel Terbit', $totalPublished)
                ->description('Total artikel publik')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Draft Artikel', $totalDraft)
                ->description('Artikel yang belum rilis')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
        ];
    }
}
