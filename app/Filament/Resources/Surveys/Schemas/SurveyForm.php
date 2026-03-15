<?php

namespace App\Filament\Resources\Surveys\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SurveyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama Survei')
                    ->description('Tentukan judul, target, dan durasi aktif survei.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Judul Survei')
                                ->required()
                                ->placeholder('Contoh: Survei Kepuasan Layanan Akademik'),

                            Select::make('target_audience')
                                ->label('Target Responden')
                                ->options([
                                    'student' => 'Mahasiswa',
                                    'lecturer' => 'Dosen',
                                    'alumni' => 'Alumni',
                                    'partner' => 'Mitra Kerjasama',
                                    'public' => 'Umum/Publik',
                                ])
                                ->required(),
                        ]),

                        Textarea::make('description')
                            ->label('Deskripsi/Instruksi')
                            ->rows(3)
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            DatePicker::make('start_date')
                                ->label('Tanggal Mulai')
                                ->required()
                                ->native(false),
                            DatePicker::make('end_date')
                                ->label('Tanggal Berakhir')
                                ->required()
                                ->native(false),
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(false)
                                ->inline(false),
                        ]),
                    ]),

                Section::make('Daftar Pertanyaan')
                    ->description('Tambahkan pertanyaan kuesioner di bawah ini.')
                    ->schema([
                        Repeater::make('questions')
                            ->relationship('questions')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('question_text')
                                        ->label('Isi Pertanyaan')
                                        ->required()
                                        ->columnSpan(1),

                                    Select::make('type')
                                        ->label('Tipe Jawaban')
                                        ->options([
                                            'likert' => 'Skala Likert (1-5)',
                                            'multiple_choice' => 'Pilihan Ganda',
                                            'text' => 'Teks Bebas / Esai',
                                            'boolean' => 'Ya / Tidak',
                                        ])
                                        ->required()
                                        ->reactive(),
                                ]),

                                KeyValue::make('options')
                                    ->label('Opsi Pilihan (Hanya untuk Pilihan Ganda)')
                                    ->visible(fn($get) => $get('type') === 'multiple_choice')
                                    ->keyLabel('Kode')
                                    ->valueLabel('Label Pilihan')
                                    ->keyPlaceholder('Contoh: A')
                                    ->valuePlaceholder('Contoh: Sangat Puas'),

                                Grid::make(2)->schema([
                                    Toggle::make('is_required')
                                        ->label('Wajib Diisi')
                                        ->default(true),
                                    TextInput::make('order_column')
                                        ->label('Urutan')
                                        ->numeric()
                                        ->default(0),
                                ]),
                            ])
                            ->itemLabel(fn(array $state): ?string => $state['question_text'] ?? null)
                            ->collapsible()
                            ->addActionLabel('Tambah Pertanyaan Baru')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
