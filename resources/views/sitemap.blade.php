<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
    </url>
    @foreach ($posts as $post)
        <url>
            <loc>{{ route('post.show', $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach
    @foreach ($categories as $category)
        <url>
            <loc>{{ route('category.show', $category->slug) }}</loc>
            <priority>0.5</priority>
        </url>
    @endforeach
</urlset>
