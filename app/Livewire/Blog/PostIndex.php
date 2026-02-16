<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Traits\HasSeo;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndex extends Component
{
    use WithPagination; // Karena ini Shared Hosting, gunakan pagination agar load ringan
    use HasSeo;

    public function mount()
    {
        // Memanggil Trait SEO dari BaseModel melalui model Post atau langsung
        $this->setSeo(
            title: 'Berita & Artikel Terbaru',
            description: 'Temukan berbagai informasi menarik dan tutorial profesional di sini.',
            image: asset('images/og-default.jpg')
        );
    }

    public function render()
    {
        return view('livewire.blog.post-index', [
            // Gunakan eager loading (with) agar tidak N+1 query
            'posts' => Post::with(['category', 'author'])
                ->where('is_published', true)
                ->latest()
                ->paginate(9)
        ]);
    }
}
