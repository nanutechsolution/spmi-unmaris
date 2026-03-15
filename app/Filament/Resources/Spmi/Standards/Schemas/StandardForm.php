<?php

namespace App\Filament\Resources\Spmi\Standards\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StandardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Standar')
                    ->description('Detail utama standar mutu universitas')
                    ->schema([
                        TextInput::make('code')
                            ->label('Kode Standar')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: STD-01'),
                        TextInput::make('title')
                            ->label('Judul Standar')
                            ->required()
                            ->placeholder('Masukkan judul standar'),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->rows(3),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columnSpan(1),

                Section::make('Indikator Kinerja')
                    ->description('Daftar indikator yang harus dipenuhi')
                    ->schema([
                        Repeater::make('indicators')
                            ->relationship('indicators')
                            ->schema([
                                TextInput::make('code')
                                    ->label('ID Indikator')
                                    ->required()
                                    ->placeholder('IND-01.1'),
                                TextInput::make('target_value')
                                    ->label('Target Angka')
                                    ->numeric(),
                                TextInput::make('unit_of_measurement')
                                    ->label('Satuan')
                                    ->placeholder('%, Skor, Hari'),
                                TextInput::make('measurement_method')
                                    ->label('Metode Ukur')
                                    ->placeholder('Contoh: Survei, Observasi'),
                                TextInput::make('siakad_responsible_unit_id')
                                    ->label('Unit Penanggung Jawab')
                                    ->placeholder('ID Unit SIAKAD'),
                                Textarea::make('indicator_statement') // Nama kolom sesuai DB Anda
                                    ->label('Pernyataan Indikator')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['code'] ?? null)
                            ->addActionLabel('Tambah Indikator Baru')
                            ->grid(1),
                    ])
            ]);
    }
}
