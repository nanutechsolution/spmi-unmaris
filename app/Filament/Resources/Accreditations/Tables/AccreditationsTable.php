<?php

namespace App\Filament\Resources\Accreditations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccreditationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prodi_name')->label('Program Studi')->searchable()->weight('bold'),
                TextColumn::make('level')->label('Jenjang')->badge()->color('gray'),
                TextColumn::make('rank')->label('Peringkat')
                    ->badge()
                    ->color(fn($record) => $record->color),
                TextColumn::make('expiry_year')->label('Berlaku s/d')->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
