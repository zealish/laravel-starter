<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends BaseModel
{
    protected $fillable = ['name', 'slug'];

    /**
     * Relasi ke Post
     * Satu kategori bisa memiliki banyak post.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Helper untuk SEO Dinamis Halaman Kategori
     * (Berguna jika Anda membuat halaman daftar post per kategori)
     */
    public function getDynamicSeo()
    {
        return [
            'title' => "Kategori: " . $this->name,
            'description' => "Kumpulan artikel dalam kategori " . $this->name,
            'image' => null, // Bisa diarahkan ke default logo
        ];
    }
}
