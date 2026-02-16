<?php

namespace App\Models;

class Post extends BaseModel
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'content',
        'image',
        'is_published',
        'seo_title',
        'seo_descriptionS'
    ];

    public function getDynamicSeo()
    {
        return [
            'title' => $this->seo_title ?? $this->title,
            'description' => $this->seo_description ?? str($this->content)->stripTags()->limit(160),
            'image' => $this->image ? asset('storage/' . $this->image) : asset('default-meta.jpg'),
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
