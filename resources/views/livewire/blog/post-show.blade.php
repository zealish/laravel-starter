<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumbs & Meta --}}
    <nav class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Beranda</a>
        <svg class="h-4 w-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" />
        </svg>
        <a href="{{ route('category.show', $post->category->slug) }}"
            class="hover:text-blue-600 transition">{{ $post->category->name }}</a>
    </nav>

    {{-- Title Section --}}
    <header class="mb-10 text-center md:text-left">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight">
            {{ $post->title }}
        </h1>

        <div class="mt-6 flex flex-wrap items-center gap-4 text-gray-600">
            <div class="flex items-center space-x-2">
                <span
                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                    {{ substr($post->author->name, 0, 1) }}
                </span>
                <span class="font-medium">{{ $post->author->name }}</span>
            </div>
            <span class="hidden md:inline">&bull;</span>
            <time>{{ $post->created_at->format('d F Y') }}</time>
        </div>
    </header>

    {{-- Featured Image --}}
    @if ($post->image)
        <div class="mb-10 rounded-2xl overflow-hidden shadow-lg border border-gray-100">
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                class="w-full h-auto object-cover">
        </div>
    @endif

    {{-- Content --}}
    <div
        class="mt-8 prose prose-lg prose-slate max-w-none 
            prose-headings:font-bold 
            prose-a:text-blue-600 
            prose-img:rounded-2xl 
            prose-pre:bg-gray-900">
        {!! $post->content !!}
    </div>

    {{-- Tags Section --}}
    @if ($post->tags->count() > 0)
        <div class="mt-12 pt-6 border-t border-gray-100">
            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Topik Terkait:</h4>
            <div class="flex flex-wrap gap-2">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}"
                        class="px-3 py-1 bg-gray-100 hover:bg-blue-600 hover:text-white rounded-lg text-sm text-gray-600 transition">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Footer Navigation --}}
    <div class="mt-16 py-8 border-y border-gray-100 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-blue-600 font-bold hover:underline flex items-center gap-2"
            wire:navigate>
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
