<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Models\Post;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Cover')
                    ->circular()
                    ->disk('public') // Pastikan storage:link sudah jalan di hosting
                    ->toggleable(),

                // 2. Info Utama (Judul & Kategori)
                TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->searchable()
                    ->sortable()
                    ->wrap() // Agar judul panjang tidak memotong tabel
                    ->description(fn(Post $record): string => "Kategori: {$record->category?->name}"),

                // 3. Author (Informatif)
                TextColumn::make('author.name')
                    ->label('Penulis')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                // 4. Tags (Multi-informasi dalam satu kolom)
                TextColumn::make('tags.name')
                    ->label('Tags')
                    ->badge()
                    ->color('info')
                    ->separator(',')
                    ->limitList(2) // Agar tabel tidak melar jika tag terlalu banyak
                    ->toggleable(isToggledHiddenByDefault: true),

                // 5. Status Publikasi (Fungsional - Bisa ganti status tanpa Edit)
                ToggleColumn::make('is_published')
                    ->label('Publish')
                    ->onColor('success')
                    ->offColor('danger'),

                // 6. Tanggal Dibuat
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada artikel')
            ->emptyStateDescription('Mulai buat artikel pertama Anda untuk mengisi daftar ini.')
            ->defaultSort('created_at', 'desc');
    }
}
