<?php

namespace App\Filament\Resources\Documents\Tables;

use App\Models\Document;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_number')
                    ->label('No. Dokumen')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'review' => 'warning',
                        'approved' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('version')
                    ->label('Versi')
                    ->alignCenter(),

                TextColumn::make('updated_at')
                    ->label('Update Terakhir')
                    ->dateTime('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Filter Kategori')
                    ->options([
                        'kebijakan' => 'Kebijakan Mutu',
                        'manual' => 'Manual Mutu',
                        'standar' => 'Standar Mutu',
                        'formulir' => 'Formulir Mutu',
                        'akreditasi' => 'Dokumen Akreditasi',
                    ]),
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'draft' => 'Draft',
                        'review' => 'Review',
                        'approved' => 'Approved',
                        'archived' => 'Archived',
                    ]),
                Filter::make('expired')
                    ->label('Dokumen Kadaluarsa')
                    ->query(fn(Builder $query): Builder => $query->where('valid_until', '<', now())),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Document $record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
                Action::make('revise')
                    ->label('Buat Revisi')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->visible(fn(Document $record) => $record->status === 'approved')
                    ->form([
                        TextInput::make('new_version')
                            ->label('Versi Baru')
                            ->required()
                            ->default(fn(Document $record) => (float)$record->version + 0.1),
                        FileUpload::make('new_file')
                            ->label('Upload Berkas PDF Baru')
                            ->directory('spmi-documents')
                            ->acceptedFileTypes(['application/pdf'])
                            ->required(),
                        DatePicker::make('new_valid_until')
                            ->label('Masa Berlaku Baru')
                            ->native(false),
                    ])
                    ->action(function (Document $record, array $data): void {
                        // 1. Arsipkan dokumen lama
                        $record->update(['status' => 'archived']);
                        // 2. Buat dokumen baru hasil kloning
                        Document::create([
                            'document_number' => $record->document_number,
                            'title' => $record->title,
                            'category' => $record->category,
                            'version' => $data['new_version'],
                            'file_path' => $data['new_file'],
                            'status' => 'approved',
                            'uploaded_by' => auth()->id(),
                            'spmi_standard_id' => $record->spmi_standard_id,
                            'valid_until' => $data['new_valid_until'],
                            'last_reviewed_at' => now(),
                        ]);
                        Notification::make()
                            ->title('Revisi Dokumen Berhasil')
                            ->body('Dokumen lama telah diarsipkan dan versi baru telah diterbitkan.')
                            ->success()
                            ->send();
                    }),

                Action::make('download')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Document $record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
