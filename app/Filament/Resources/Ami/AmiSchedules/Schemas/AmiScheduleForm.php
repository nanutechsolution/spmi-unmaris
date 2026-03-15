<?php

namespace App\Filament\Resources\Ami\AmiSchedules\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Fieldset;
use Filament\Schemas\Components\Fieldset as ComponentsFieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AmiScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: HEADER PENJADWALAN
                Section::make('Informasi Penjadwalan Audit')
                    ->description('Tentukan siklus, unit yang diaudit, dan personel auditor.')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('ami_cycle_id')
                                ->label('Siklus AMI')
                                ->relationship('cycle', 'name')
                                ->required()
                                ->searchable()
                                ->preload(),

                            DatePicker::make('audit_date')
                                ->label('Tanggal Pelaksanaan')
                                ->required()
                                ->native(false),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('siakad_unit_id')
                                ->label('ID Unit / Prodi (SIAKAD)')
                                ->required()
                                ->placeholder('Contoh: INF-01 atau UUID unit'),

                            TextInput::make('siakad_auditor_id')
                                ->label('ID Ketua Auditor (SIAKAD)')
                                ->required()
                                ->placeholder('Masukkan NIDN atau ID Auditor'),
                        ]),

                        Select::make('status')
                            ->label('Status Audit Keseluruhan')
                            ->options([
                                'scheduled' => 'Scheduled (Dijadwalkan)',
                                'in_progress' => 'In Progress (Sedang Berjalan)',
                                'completed' => 'Completed (Selesai)',
                            ])
                            ->default('scheduled')
                            ->required(),
                    ]),

                // SECTION 2: REPEATER TEMUAN & TINDAK LANJUT
                Section::make('Daftar Temuan Audit (KTS)')
                    ->description('Catat setiap temuan ketidaksesuaian berdasarkan Standar SPMI.')
                    ->schema([
                        Repeater::make('findings')
                            ->relationship('findings') // Relasi ke model AmiFinding
                            ->schema([
                                Grid::make(3)->schema([
                                    Select::make('spmi_standard_id')
                                        ->label('Standar yang Terkait')
                                        ->relationship('standard', 'title')
                                        ->required()
                                        ->searchable()
                                        ->columnSpan(2),

                                    Select::make('type')
                                        ->label('Tipe Temuan')
                                        ->options([
                                            'observation' => 'Observasi (OB)',
                                            'minor' => 'KTS Minor',
                                            'major' => 'KTS Mayor',
                                        ])
                                        ->required(),
                                ]),

                                Textarea::make('description')
                                    ->label('Deskripsi Temuan / Kesenjangan')
                                    ->placeholder('Uraikan fakta temuan di lapangan...')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),

                                ComponentsFieldset::make('Rencana Tindak Lanjut & Koreksi')
                                    ->schema([
                                        Textarea::make('corrective_action_plan')
                                            ->label('Uraian RTL (Oleh Auditee)')
                                            ->placeholder('Langkah perbaikan yang akan diambil...')
                                            ->rows(2)
                                            ->columnSpanFull(),

                                        DatePicker::make('target_completion_date')
                                            ->label('Target Selesai')
                                            ->native(false),

                                        Select::make('status')
                                            ->label('Status Temuan')
                                            ->options([
                                                'open' => 'Open',
                                                'in_progress' => 'In Progress',
                                                'corrected' => 'Corrected (Sudah Diperbaiki)',
                                                'verified' => 'Verified (Terverifikasi)',
                                                'closed' => 'Closed',
                                            ])
                                            ->default('open')
                                            ->required(),
                                    ]),

                                Textarea::make('verification_notes')
                                    ->label('Catatan Verifikasi (Oleh LPM)')
                                    ->placeholder('Catatan tambahan saat verifikasi hasil perbaikan...')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                ($state['type'] ?? 'Temuan Baru') . ' - ' . ($state['status'] ?? 'Open')
                            )
                            ->addActionLabel('Tambah Temuan KTS')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}