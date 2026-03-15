<?php

namespace App\Filament\Resources\SurveyResponses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SurveyResponsesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('survey.title')
                    ->label('Nama Survei')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('respondent_id')
                    ->label('ID Responden')
                    ->searchable()
                    ->placeholder('Anonim'),

                TextColumn::make('respondent_type')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('submitted_at')
                    ->label('Dikirim Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('answers_count')
                    ->label('Jml Jawaban')
                    ->counts('answers')
                    ->badge()
                    ->color('info'),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->filters([
                SelectFilter::make('survey_id')
                    ->label('Filter Survei')
                    ->relationship('survey', 'title'),

                SelectFilter::make('respondent_type')
                    ->label('Filter Kategori')
                    ->options([
                        'student' => 'Mahasiswa',
                        'lecturer' => 'Dosen',
                        'alumni' => 'Alumni',
                        'partner' => 'Mitra',
                        'public' => 'Umum',
                    ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Detail')
                    ->modalHeading('Detail Jawaban Responden'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
