<?php

namespace App\Filament\Resources\Rtms\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RtmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pelaksanaan RTM')
                    ->description('Dokumentasikan hasil rapat tinjauan manajemen berdasarkan temuan AMI.')
                    ->schema([
                        Select::make('ami_cycle_id')
                            ->label('Berdasarkan Siklus AMI')
                            ->relationship('cycle', 'name')
                            ->required()
                            ->searchable(),
                        DatePicker::make('meeting_date')
                            ->label('Tanggal Rapat')
                            ->required()
                            ->native(false),

                        TextInput::make('location')
                            ->label('Tempat/Ruang Rapat')
                            ->required()
                            ->placeholder('Contoh: Ruang Rapat Rektorat'),

                        TagsInput::make('attendees')
                            ->label('Daftar Pejabat Hadir')
                            ->placeholder('Tambah nama...')
                            ->suggestions([
                                'Rektor',
                                'Wakil Rektor 1',
                                'Kepala LPM',
                                'Dekan FTI'
                            ]),

                        TextInput::make('agenda')
                            ->label('Agenda Utama')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('Hasil & Keputusan Rapat')
                    ->schema([
                        RichEditor::make('minutes')
                            ->label('Notulensi Rapat')
                            ->placeholder('Uraikan jalannya diskusi...')
                            ->required()
                            ->columnSpanFull(),

                        RichEditor::make('conclusions')
                            ->label('Rekomendasi & Keputusan Strategis')
                            ->placeholder('Tuliskan keputusan yang diambil pimpinan untuk peningkatan mutu...')
                            ->required()
                            ->columnSpanFull(),

                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'final' => 'Final (Tersosialisasi)',
                            ])
                            ->default('draft')
                            ->required(),
                    ])
            ]);
    }
}
