<?php

use App\Livewire\Blog\PostIndex;
use App\Livewire\Blog\PostShow;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Halaman Beranda - Menampilkan daftar semua post
Route::get('/', PostIndex::class)->name('home');

// Halaman Detail Artikel - Menggunakan slug untuk SEO
Route::get('/post/{slug}', PostShow::class)->name('post.show');

// Halaman Daftar Post berdasarkan Kategori
Route::get('/category/{slug}', PostIndex::class)->name('category.show');

// Halaman Daftar Post berdasarkan Tag
Route::get('/tag/{slug}', PostIndex::class)->name('tag.show');


/*
|--------------------------------------------------------------------------
| Shared Hosting Utilities (Optional but Recommended)
|--------------------------------------------------------------------------
*/

// Route rahasia untuk clear cache di shared hosting tanpa SSH
Route::get('/optimize-force', function () {
    if (config('app.env') === 'production') {
        \Illuminate\Support\Facades\Artisan::call('config:cache');
        \Illuminate\Support\Facades\Artisan::call('route:cache');
        \Illuminate\Support\Facades\Artisan::call('view:cache');
        return "System Optimized!";
    }
    return abort(404);
})->middleware('auth'); // Pastikan hanya admin yang bisa akses

Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);
