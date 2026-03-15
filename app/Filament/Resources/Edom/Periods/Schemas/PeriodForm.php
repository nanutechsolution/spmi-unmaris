<?php

namespace App\Filament\Resources\Edom\Periods\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Http;

class PeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konfigurasi Semester')
                    ->schema([
                        Select::make('siakad_semester_id')
                            ->label('Pilih Semester SIAKAD')
                            ->options(function () {
                                try {
                                    return Http::withHeaders(['X-SIMA-KEY' => config('services.siakad.api_key')])
                                        ->get(config('services.siakad.url') . "/api/v1/semesters")
                                        ->json('data.*.name', 'data.*.id');
                                } catch (\Exception $e) {
                                    return [];
                                }
                            })
                            ->required(),
                        TextInput::make('name')
                            ->label('Nama Periode')
                            ->required()
                            ->placeholder('Contoh: Ganjil 2025/2026'),
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Tanggal Berakhir')
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Hanya satu periode yang boleh aktif untuk pengisian mahasiswa.')
                            ->default(false),
                    ])->columns(2),
            ]);
    }
}
