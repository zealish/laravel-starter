<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Core\FileFactory;
use App\Models\Post;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Post Management')
                    ->tabs([

                        // TAB 1: KONTEN UTAMA
                        Tab::make('Konten Utama')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Artikel')
                                    ->placeholder('Masukkan judul yang menarik...')
                                    ->helperText('Judul adalah hal pertama yang dilihat pembaca.')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($set, $state) => $set('slug', str($state)->slug())),

                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->placeholder('halaman-artikel-anda')
                                    ->helperText('Akan menjadi alamat URL artikel (Contoh: domain.com/p/slug).')
                                    ->required()
                                    ->unique(Post::class, 'slug', ignoreRecord: true),

                                RichEditor::make('content')
                                    ->label('Isi Konten')
                                    ->helperText('Gunakan format yang rapi agar nyaman dibaca.')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),

                        // TAB 2: RELASI & MEDIA
                        Tab::make('Atribut & Media')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Grid::make(2)->schema([
                                    Select::make('user_id')
                                        ->label('Penulis (Author)')
                                        ->relationship('author', 'name') // Mengacu pada relasi 'author' di model Post
                                        ->default(auth()->guard()->id()) // Otomatis mengisi dengan ID user yang sedang login
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->hint('Default: Akun yang sedang login.')
                                        ->helperText('Anda bisa mengubah penulis jika memiliki akses manajemen user.')
                                        ->columnSpanFull(),

                                    Select::make('category_id')
                                        ->label('Kategori')
                                        ->relationship('category', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->hint('Klik ikon + untuk tambah kategori baru.')
                                        ->createOptionForm([
                                            TextInput::make('name')->required(),
                                            TextInput::make('slug')->required()->unique('categories', 'slug'),
                                        ]),

                                    Select::make('tags')
                                        ->label('Tagar (Tags)')
                                        ->relationship('tags', 'name')
                                        ->multiple()
                                        ->preload()
                                        ->hint('Pilih satu atau lebih tagar terkait.')
                                        ->createOptionForm([
                                            TextInput::make('name')->required(),
                                            TextInput::make('slug')->required()->unique('tags', 'slug'),
                                        ]),

                                    FileFactory::optimizedImage('image', 'posts')
                                        ->label('Gambar Utama')
                                        ->hint('Rekomendasi ukuran: 1200x630px.')
                                        ->helperText('Gambar ini akan muncul di daftar blog dan saat dibagikan ke media sosial.')
                                        ->columnSpanFull(),

                                    Toggle::make('is_published')
                                        ->label('Status Publikasi')
                                        ->helperText('Artikel tidak akan muncul di frontend jika dalam status Draft.')
                                        ->onColor('success')
                                        ->offColor('danger'),
                                ]),
                            ]),

                        // TAB 3: OPTIMASI SEO
                        Tab::make('SEO Tuning')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make('Search Engine Metadata')
                                    ->description('Kendalikan bagaimana Google melihat halaman ini.')
                                    ->schema([
                                        TextInput::make('seo_title')
                                            ->label('Meta Title')
                                            ->placeholder('Default: Menggunakan judul artikel')
                                            ->maxLength(60)
                                            ->hint(fn($state) => strlen($state) . '/60 Karakter')
                                            ->helperText('Jika kosong, akan menggunakan Judul Artikel. Idealnya 50-60 karakter.'),

                                        Textarea::make('seo_description')
                                            ->label('Meta Description')
                                            ->placeholder('Default: Menggunakan cuplikan konten')
                                            ->maxLength(160)
                                            ->hint(fn($state) => strlen($state) . '/160 Karakter')
                                            ->helperText('Ringkasan yang muncul di hasil pencarian Google. Maksimal 160 karakter.'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
