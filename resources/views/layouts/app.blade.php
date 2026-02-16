<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO & JSON-LD (Hanya panggil satu kali di sini) --}}
    {!! SEO::generate() !!}
    {!! JsonLd::generate() !!}

    {{-- Render Google Analytics dari Spatie Settings --}}
    @php
        $settings = app(App\Settings\GeneralSettings::class);
    @endphp

    @if ($settings->google_analytics)
        {!! $settings->google_analytics !!}
    @endif

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-gray-50 antialiased font-sans">
    {{-- Progress Bar (Jika Anda memasangnya di layout agar muncul di semua halaman) --}}
    <div x-data="{ scroll: 0 }"
        @scroll.window="scroll = (window.pageYOffset / (document.body.scrollHeight - window.innerHeight)) * 100"
        class="fixed top-0 left-0 w-full h-1 z-50 pointer-events-none">
        <div class="h-full bg-blue-600 transition-all duration-150 ease-out" :style="`width: ${scroll}%`"
            style="width: 0%;"></div>
    </div>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>
