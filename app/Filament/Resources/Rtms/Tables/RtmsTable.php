<?php

namespace App\Filament\Resources\Rtms\Tables;

use App\Models\Ami\Rtm;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;

class RtmsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('meeting_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                TextColumn::make('cycle.name')
                    ->label('Siklus Audit')
                    ->badge(),

                TextColumn::make('location')
                    ->label('Lokasi'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'final' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('export_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(function (Rtm $record) {
                        $pdf = Pdf::loadView('exports.rtm-pdf', [
                            'record' => $record,
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->stream();
                        }, 'RTM-' . $record->meeting_date->format('d-m-Y') . '.pdf');
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
