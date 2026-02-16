<?php

namespace App\Filament\Widgets;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Exception;

class AnalyticsOverview extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        try {
            // Mengambil data untuk 7 hari terakhir
            $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));

            $totalVisitors = $analyticsData->sum('visitors');
            $totalPageViews = $analyticsData->sum('pageViews');

            return [
                Stat::make('Total Pengunjung (7 Hari)', number_format($totalVisitors))
                    ->description('Pengunjung unik dari GA4')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('success'),

                Stat::make('Total Page Views', number_format($totalPageViews))
                    ->description('Total halaman yang dilihat')
                    ->descriptionIcon('heroicon-m-eye')
                    ->color('info'),
            ];
        } catch (Exception $e) {
            // Jika API belum terkoneksi, tampilkan stat kosong agar tidak crash
            return [
                Stat::make('Analytics', 'Pending')
                    ->description('Pastikan Property ID & JSON Key sudah benar')
                    ->color('gray'),
            ];
        }
    }
}
