<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Kita paksa menggunakan style property agar tidak tergantung pada class Tailwind --}}
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; width: 100%;">

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="padding: 0.5rem; background-color: rgba(156, 163, 175, 0.1); border-radius: 0.5rem;">
                    <x-filament::icon icon="heroicon-o-cpu-chip" style="height: 1.5rem; width: 1.5rem; color: #6b7280;" />
                </div>
                <div>
                    <h2 style="font-size: 1rem; font-weight: 600; line-height: 1.75rem;">
                        Optimasi Sistem
                    </h2>
                    <p style="font-size: 0.75rem; color: #6b7280;">
                        Update data & hapus cache sistem.
                    </p>
                </div>
            </div>

            <div style="flex-shrink: 0;">
                {{ $this->clearAction }}
            </div>
        </div>
    </x-filament::section>

    <x-filament-actions::modals />
</x-filament-widgets::widget>
