<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Livewire\Component;
use App\Traits\HasSeo;
use Illuminate\Support\Facades\Cache;

class PostShow extends Component
{
    use HasSeo;

    public $post;

    public function mount($slug)
    {
        // Global Caching: Simpan data post selama 1 jam
        // Cache akan otomatis terhapus saat Post di-update berkat logic di BaseModel kita
        $this->post = Cache::remember("post_detail_{$slug}", 3600, function () use ($slug) {
            return Post::with(['category', 'author', 'tags'])
                ->where('slug', $slug)
                ->where('is_published', true)
                ->firstOrFail();
        });

        // Ambil SEO dinamis dari model
        $seo = $this->post->getDynamicSeo();

        // 1. Set Basic SEO
        $this->setSeo($seo['title'], $seo['description'], $seo['image'], 'Article');

        // 2. Set Auto Keywords dari Tags
        $this->setKeywords($this->post->tags);

        // 3. Set Rich Snippet JSON-LD
        $this->setArticleSchema($this->post);

        // 4. Set Breadcrumbs
        $this->setBreadcrumbSchema([
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $this->post->category->name, 'url' => route('category.show', $this->post->category->slug)],
            ['name' => $this->post->title, 'url' => route('post.show', $this->post->slug)],
        ]);
    }

    public function render()
    {
        return view('livewire.blog.post-show');
    }
}
