<?php

namespace App\Filament\Resources\Accreditations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AccreditationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akreditasi Program Studi')
                    ->schema([
                        TextInput::make('prodi_name')
                            ->label('Nama Program Studi')
                            ->required()
                            ->placeholder('Contoh: Informatika'),

                        TextInput::make('level')
                            ->label('Jenjang')
                            ->default('S1')
                            ->required(),

                        Select::make('rank')
                            ->label('Peringkat Akreditasi')
                            ->options([
                                'Unggul' => 'Unggul',
                                'Baik Sekali' => 'Baik Sekali',
                                'Baik' => 'Baik',
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                            ])
                            ->required(),

                        TextInput::make('expiry_year')
                            ->label('Tahun Berakhir (Masa Berlaku)')
                            ->numeric()
                            ->maxLength(4)
                            ->required(),

                        Select::make('color')
                            ->label('Warna Badge')
                            ->options([
                                'amber' => 'Emas / Kuning (Unggul)',
                                'blue' => 'Biru (Baik Sekali)',
                                'emerald' => 'Hijau (Baik)',
                                'slate' => 'Abu-abu (Lainnya)',
                            ])
                            ->default('blue')
                            ->required(),

                        FileUpload::make('certificate_file')
                            ->label('Sertifikat Akreditasi (PDF)')
                            ->directory('accreditations')
                            ->acceptedFileTypes(['application/pdf'])
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
