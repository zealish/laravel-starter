<?php

namespace App\Core;

use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class FileFactory
{
    public static function optimizedImage(string $name, string $directory = 'uploads'): FileUpload
    {
        return FileUpload::make($name)
            ->directory($directory)
            ->image()
            ->imageEditor()
            // Mengubah file ke WebP sesaat setelah diupload ke folder temporary
            ->saveUploadedFileUsing(function ($file, $component) use ($directory) {
                $filename = Str::random(40) . '.webp';

                // Proses konversi dengan Intervention Image
                $optimized = Image::read($file->getRealPath())
                    ->toWebp(70); // Force WebP & Quality 70%

                // Simpan langsung ke disk public
                Storage::disk('public')->put($directory . '/' . $filename, (string) $optimized);

                return $directory . '/' . $filename;
            })
            ->afterStateUpdated(function ($state, $old, $record) use ($name) {
                if ($old && $state !== $old) {
                    Storage::disk('public')->delete($old);
                }
            })
            ->helperText('Otomatis dikonversi ke WebP dengan kualitas 70% untuk performa maksimal.');
    }
}
