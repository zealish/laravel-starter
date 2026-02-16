<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class ClearCache extends Widget implements HasForms, HasActions
{
    use InteractsWithActions, InteractsWithForms;

    protected string $view = 'filament.widgets.clear-cache';

    public function clearAction(): Action
    {
        return Action::make('clear')
            ->label('Clear Cache') // Nama lebih ringkas
            ->color('danger')
            ->outlined() // Membuat style tombol outline agar tidak terlalu dominan
            ->size('sm')
            ->requiresConfirmation()
            ->modalHeading('Bersihkan Cache Sistem?')
            ->modalDescription('Tindakan ini akan menghapus semua cache aplikasi, view, dan konfigurasi.')
            ->modalSubmitActionLabel('Ya, Bersihkan')
            ->action(function () {
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('settings:clear-cache');

                Notification::make()
                    ->title('Sistem Dioptimasi')
                    ->success()
                    ->send();
            });
    }
}
