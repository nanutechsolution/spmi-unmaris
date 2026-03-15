<?php

namespace App\Filament\Resources\LpmProfiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class LpmProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Profil LPM')
                    ->tabs([
                        Tabs\Tab::make('Teks Beranda')
                            ->icon('heroicon-m-home')
                            ->schema([
                                TextInput::make('hero_title')
                                    ->label('Judul Utama (Hero)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('hero_description')
                                    ->label('Deskripsi Singkat')
                                    ->rows(4)
                                    ->required(),
                            ]),

                        Tabs\Tab::make('Visi & Misi')
                            ->icon('heroicon-m-sparkles')
                            ->schema([
                                Textarea::make('vision')
                                    ->label('Visi Lembaga')
                                    ->rows(3)
                                    ->required(),

                                Repeater::make('missions')
                                    ->label('Daftar Misi')
                                    ->schema([
                                        TextInput::make('text')
                                            ->label('Teks Misi')
                                            ->required(),
                                        Select::make('icon')
                                            ->label('Ikon')
                                            ->options([
                                                'target' => 'Target (Fokus)',
                                                'users' => 'Users (SDM)',
                                                'check-badge' => 'Badge (Standar/Kualitas)',
                                                'trending-up' => 'Trending (Peningkatan)',
                                                'award' => 'Award (Penghargaan/Akreditasi)',
                                            ])
                                            ->default('check-badge')
                                            ->required(),
                                    ])
                                    ->collapsible()
                                    ->addActionLabel('Tambah Misi Baru'),
                            ]),
                        Tabs\Tab::make('Siklus PPEPP')
                            ->icon('heroicon-m-arrow-path-rounded-square')
                            ->schema([
                                Repeater::make('ppepp_steps')
                                    ->label('Langkah-Langkah Siklus Mutu')
                                    ->schema([
                                        TextInput::make('short')
                                            ->label('Inisial Singkat (Misal: P, E)')
                                            ->required()
                                            ->maxLength(1),
                                        TextInput::make('title')
                                            ->label('Judul Tahapan')
                                            ->required()
                                            ->placeholder('Contoh: Penetapan'),
                                        Textarea::make('description')
                                            ->label('Deskripsi Proses')
                                            ->required()
                                            ->rows(2),
                                    ])
                                    ->collapsible()
                                    ->defaultItems(5)
                                    ->addActionLabel('Tambah Langkah PPEPP'),
                            ]),

                        Tabs\Tab::make('Struktur Organisasi')
                            ->icon('heroicon-m-user-group')
                            ->schema([
                                FileUpload::make('org_structure_image')
                                    ->label('Bagan Struktur Organisasi')
                                    ->image()
                                    ->directory('lpm-profiles')
                                    ->preserveFilenames()
                                    ->helperText('Unggah gambar bagan struktur organisasi lembaga.'),
                            ]),

                        Tabs\Tab::make('Kontak & Sosmed')
                            ->icon('heroicon-m-phone')
                            ->schema([
                                TextInput::make('address')
                                    ->label('Alamat Lengkap')
                                    ->columnSpanFull(),
                                TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->tel(),
                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email(),

                                Repeater::make('social_media')
                                    ->label('Sosial Media')
                                    ->schema([
                                        Select::make('platform')
                                            ->options([
                                                'instagram' => 'Instagram',
                                                'facebook' => 'Facebook',
                                                'youtube' => 'YouTube',
                                                'twitter' => 'Twitter / X',
                                            ])
                                            ->required(),
                                        TextInput::make('url')
                                            ->label('URL / Link')
                                            ->url()
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel('Tambah Sosial Media')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpanFull()
            ]);
    }
}
