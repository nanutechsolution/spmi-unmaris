<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokumen')
                    ->description('Pastikan nomor dokumen sesuai dengan pedoman pengkodean universitas.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('document_number')
                                ->label('Nomor Dokumen')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->placeholder('Contoh: UNMARIS/SPMI/STD/01'),

                            TextInput::make('title')
                                ->label('Nama/Judul Dokumen')
                                ->required()
                                ->placeholder('Contoh: Standar Mutu Pendidikan'),
                        ]),

                        Grid::make(3)->schema([
                            Select::make('category')
                                ->label('Kategori')
                                ->options([
                                    'kebijakan' => 'Kebijakan Mutu',
                                    'manual' => 'Manual Mutu',
                                    'standar' => 'Standar Mutu',
                                    'formulir' => 'Formulir Mutu',
                                    'akreditasi' => 'Dokumen Akreditasi',
                                ])
                                ->required(),

                            TextInput::make('version')
                                ->label('Versi')
                                ->default('1.0')
                                ->required(),

                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'draft' => 'Draft',
                                    'review' => 'Dalam Review',
                                    'approved' => 'Approved (Aktif)',
                                    'archived' => 'Archived (Arsip)',
                                ])
                                ->default('draft')
                                ->required(),
                        ]),

                        Select::make('spmi_standard_id')
                            ->label('Terkait Standar SPMI (Opsional)')
                            ->relationship('standard', 'title')
                            ->searchable()
                            ->preload(),
                    ]),

                Section::make('Berkas Dokumen')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('Upload File (PDF)')
                            ->directory('spmi-documents')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120)
                            ->required()
                            ->downloadable()
                            ->openable(),
                        Hidden::make('uploaded_by')
                            ->default(auth()->id()),
                    ])
            ]);
    }
}
