<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Header Section --}}
    <div class="mb-12 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
            Berita & Artikel Terbaru
        </h1>
        <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">
            Temukan berbagai wawasan profesional, tutorial, dan update terbaru langsung dari tim kami.
        </p>
    </div>

    {{-- Grid Articles --}}
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse($posts as $post)
            <article
                class="flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 overflow-hidden">
                {{-- Image Thumbnail --}}
                <div class="relative h-52 w-full overflow-hidden">
                    @if ($post->image)
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                            src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                    @else
                        <div class="flex items-center justify-center w-full h-full bg-gray-100 text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endif

                    {{-- Category Badge --}}
                    <div class="absolute top-4 left-4">
                        <a href="{{ route('category.show', $post->category->slug) }}"
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white uppercase tracking-wider shadow-sm hover:bg-blue-700">
                            {{ $post->category->name }}
                        </a>
                    </div>
                </div>

                {{-- Content Body --}}
                <div class="flex-1 p-6 flex flex-col justify-between">
                    <div class="flex-1">
                        <a href="{{ route('post.show', $post->slug) }}" class="block mt-2" wire:navigate>
                            <h2
                                class="text-xl font-bold text-gray-900 hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                                {{ $post->title }}
                            </h2>
                            <p class="mt-3 text-sm text-gray-500 line-clamp-3">
                                {{ $post->seo_description ?? str($post->content)->stripTags()->limit(120) }}
                            </p>
                        </a>
                    </div>

                    {{-- Footer Info --}}
                    <div class="mt-6 flex items-center border-t border-gray-50 pt-6">
                        <div class="shrink-0">
                            <span
                                class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 font-bold text-gray-600">
                                {{ substr($post->author->name, 0, 1) }}
                            </span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $post->author->name }}
                            </p>
                            <div class="flex space-x-1 text-xs text-gray-400">
                                <time datetime="{{ $post->created_at }}">
                                    {{ $post->created_at->format('d M, Y') }}
                                </time>
                                <span aria-hidden="true">&middot;</span>
                                <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-gray-400 italic text-lg">Belum ada artikel yang diterbitkan.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-12">
        {{ $posts->links() }}
    </div>
</div>
