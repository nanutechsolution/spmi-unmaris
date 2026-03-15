<?php

namespace App\Filament\Resources\Edom\Responses\Tables;

use App\Models\Edom\Period;
use App\Models\Edom\Response;
use App\Models\Survey\Question;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ResponsesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('period.name')
                    ->label('Periode')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->getStateUsing(fn(Response $record) => Period::find($record->edom_period_id)?->name ?? 'Unknown'),

                TextColumn::make('siakad_course_id')
                    ->label('Kode MK')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('siakad_lecturer_id')
                    ->label('ID Dosen (NIDN)')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->tooltip('Klik untuk menyalin ID'),

                TextColumn::make('siakad_student_id')
                    ->label('ID Mhs (NIM)')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Disembunyikan secara default agar tidak terlalu penuh

                TextColumn::make('question.question')
                    ->label('Pertanyaan')
                    ->limit(40)
                    ->tooltip(fn($state) => $state)
                    ->getStateUsing(fn(Response $record) => Question::find($record->edom_question_id)?->question ?? '-'),

                TextColumn::make('score')
                    ->label('Skor (1-5)')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'danger',
                        '2' => 'warning',
                        '3' => 'gray',
                        '4' => 'info',
                        '5' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Waktu Submit')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('edom_period_id')
                    ->label('Filter Periode')
                    ->options(Period::pluck('name', 'id')->toArray()),

                SelectFilter::make('score')
                    ->label('Filter Skor')
                    ->options([
                        '1' => '1 - Sangat Kurang',
                        '2' => '2 - Kurang',
                        '3' => '3 - Cukup',
                        '4' => '4 - Baik',
                        '5' => '5 - Sangat Baik',
                    ]),
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
