<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends BaseModel
{
    protected $fillable = ['name', 'slug'];

    /**
     * Relasi ke Post (Pivot)
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Helper SEO Dinamis untuk Halaman Tag
     */
    public function getDynamicSeo()
    {
        return [
            'title' => "Tag: " . $this->name,
            'description' => "Menampilkan semua artikel dengan tagar " . $this->name,
            'image' => null,
        ];
    }
}
