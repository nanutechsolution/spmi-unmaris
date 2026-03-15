<?php

namespace App\Filament\Resources\Edom\Questions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class QuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('category')
                    ->badge()
                    ->sortable(),
                TextColumn::make('question_text')
                    ->label('Isi Pertanyaan')
                    ->limit(50)
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
                TextColumn::make('order_column')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('order_column')
            ->reorderable('order_column')
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
