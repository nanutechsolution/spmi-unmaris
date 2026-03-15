<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class ExpiredDocumentsWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Peringatan: Dokumen Mutu Kadaluarsa';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Document::query()
                    ->where('valid_until', '<', now())
                    ->where('status', '!=', 'archived')
            )
            ->columns([
                TextColumn::make('document_number')
                    ->label('Nomor Dokumen')
                    ->weight('bold'),
                
                TextColumn::make('title')
                    ->label('Judul Dokumen'),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge(),

                TextColumn::make('valid_until')
                    ->label('Kadaluarsa Pada')
                    ->date('d F Y')
                    ->color('danger')
                    ->weight('bold'),
            ])
            ->emptyStateHeading('Semua dokumen masih berlaku.')
            ->emptyStateIcon('heroicon-o-check-badge');
    }
}