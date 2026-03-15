<?php

namespace App\Filament\Resources\Ami\AmiSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AmiSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cycle.name')
                    ->label('Siklus')
                    ->sortable()
                    ->badge(),
                TextColumn::make('siakad_unit_id')
                    ->label('ID Unit/Prodi')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('siakad_auditor_id')
                    ->label('Ketua Auditor')
                    ->searchable(),
                TextColumn::make('audit_date')
                    ->label('Tgl Audit')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'scheduled' => 'gray',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    }),
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
