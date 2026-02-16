<?php

namespace App\Models;

use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

abstract class BaseModel extends Model
{
    use HasSeo;

    protected static function booted()
    {
        // Auto-purge cache saat data berubah
        static::saved(fn($model) => static::flushCache($model));

        static::deleted(function ($model) {
            static::flushCache($model);

            // Cek jika model memiliki kolom 'image' dan hapus filenya
            if (isset($model->image) && $model->image) {
                Storage::disk('public')->delete($model->image);
            }
        });
    }

    protected static function flushCache($model)
    {
        Cache::forget($model->getTable() . '_all');
    }

    // Method global untuk ambil data ter-cache
    public static function getAllCached()
    {
        return Cache::rememberForever(static::class . '_all', function () {
            return static::all();
        });
    }
}
