<?php

namespace App\Filament\Resources\Ami\AmiCycles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class AmiCyclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
             TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
              TextColumn::make('name')
                    ->label('Nama Siklus')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
              ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->sortable(),
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
