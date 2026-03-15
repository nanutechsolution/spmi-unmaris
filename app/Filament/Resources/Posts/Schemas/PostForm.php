<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Utama')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Berita')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            // Otomatis mengisi slug saat judul diketik (hanya pada saat Create)
                            ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Alamat URL untuk berita ini. Dibuat otomatis dari judul.'),

                        Textarea::make('excerpt')
                            ->label('Ringkasan (Excerpt)')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Teks singkat yang akan ditampilkan di card halaman depan (Landing Page).'),

                        RichEditor::make('content')
                            ->label('Isi Berita')
                            ->required()
                            ->fileAttachmentsDirectory('posts/attachments')
                            ->columnSpanFull(),
                    ]),
                Section::make('Media & Publikasi')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Gambar Utama (Thumbnail)')
                            ->image()
                            ->directory('posts/thumbnails')
                            ->preserveFilenames(),

                        Toggle::make('is_published')
                            ->label('Publikasikan Sekarang')
                            ->default(true),

                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now())
                            ->native(false)
                            ->helperText('Biarkan default untuk rilis sekarang, atau atur ke tanggal masa depan untuk dijadwalkan.'),

                        // Otomatis menetapkan penulis berdasarkan user yang login
                        Hidden::make('author_id')
                            ->default(fn() => auth()->id()),
                    ]),

                Section::make('SEO Meta Data')
                    ->description('Optimasi Mesin Pencari (Opsional)')
                    ->collapsed()
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(255)
                            ->helperText('Biarkan kosong untuk menggunakan judul utama.'),
                        Textarea::make('seo_description')
                            ->label('SEO Description')
                            ->rows(3)
                            ->maxLength(255)
                            ->helperText('Biarkan kosong untuk menggunakan ringkasan (excerpt).'),
                    ]),

            ]);
    }
}
