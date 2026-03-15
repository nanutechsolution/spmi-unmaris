<?php

namespace App\Filament\Resources\Ami\AmiCycles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AmiCycleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Siklus AMI')
                    ->schema([
                        TextInput::make('year')
                            ->label('Tahun')
                            ->numeric()
                            ->required()
                            ->maxLength(4)
                            ->placeholder('2026'),
                        TextInput::make('name')
                            ->label('Nama Siklus')
                            ->required()
                            ->placeholder('Contoh: AMI Siklus Ganjil 2026'),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(false),
                    ])->columns(2)
            ]);
    }
}
