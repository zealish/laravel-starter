<?php

namespace App\Traits;

use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\JsonLd; // Tambahkan ini

trait HasSeo
{
    public function setSeo(?string $title = null, ?string $description = null, ?string $image = null, string $type = 'WebPage')
    {
        // Mengambil data dari Spatie Settings
        $settings = app(\App\Settings\GeneralSettings::class);

        // 1. Logika Fallback: Jika parameter kosong, ambil dari Settings
        $seoTitle = $title ?: $settings->site_name;
        $seoDesc = $description ?: $settings->site_description;
        // Gunakan gambar parameter, jika tidak ada pakai logo dari settings
        $seoImage = $image ?: ($settings->site_logo ? asset('storage/' . $settings->site_logo) : null);

        // 2. Standard SEO (Meta Tags)
        SEOTools::setTitle($seoTitle);
        SEOTools::setDescription($seoDesc);
        SEOTools::setCanonical(url()->current());

        // Tambahkan keywords global dari settings
        if (!empty($settings->seo_keywords)) {
            SEOTools::metatags()->setKeywords($settings->seo_keywords);
        }

        // 3. OpenGraph (Sosial Media)
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', $type === 'Article' ? 'article' : 'website');
        SEOTools::opengraph()->setTitle($seoTitle);
        SEOTools::opengraph()->setDescription($seoDesc);

        if ($seoImage) {
            SEOTools::opengraph()->addImage($seoImage);
            JsonLd::addImage($seoImage);
        }

        // 4. JSON-LD Terstruktur
        JsonLd::setTitle($seoTitle);
        JsonLd::setDescription($seoDesc);
        JsonLd::setType($type);

        // Sinkronkan keywords di JSON-LD
        if (!empty($settings->seo_keywords)) {
            JsonLd::addValue('keywords', $settings->seo_keywords);
        }
    }

    // Fungsi khusus untuk Rich Snippet Artikel
    public function setArticleSchema($post)
    {
        JsonLd::setType('BlogPosting');
        JsonLd::addValue('datePublished', $post->created_at->toIso8601String());
        JsonLd::addValue('dateModified', $post->updated_at->toIso8601String());
        JsonLd::addValue('author', [
            '@type' => 'Person',
            'name' => $post->author->name,
        ]);
        JsonLd::addValue('publisher', [
            '@type' => 'Organization',
            'name' => config('app.name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('logo.png'), // Pastikan file logo ada
            ],
        ]);
    }

    public function setBreadcrumbSchema(array $steps)
    {
        $listItems = [];
        foreach ($steps as $index => $step) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $step['name'],
                'item' => $step['url'],
            ];
        }

        JsonLd::addValue('breadcrumb', [
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ]);
    }

    /**
     * Otomatis generate keywords dari koleksi tags
     */
    public function setKeywords($tags)
    {
        if (empty($tags)) return;

        // Jika $tags adalah Collection (Eloquent), kita ambil kolom 'name'
        // Jika string, langsung gunakan.
        $keywords = is_string($tags)
            ? $tags
            : $tags->pluck('name')->implode(', ');

        SEOTools::metatags()->setKeywords($keywords);

        // Tambahkan juga ke JSON-LD agar sinkron
        JsonLd::addValue('keywords', $keywords);
    }
}
