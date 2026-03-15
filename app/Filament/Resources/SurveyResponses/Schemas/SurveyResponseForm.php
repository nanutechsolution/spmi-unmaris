<?php

namespace App\Filament\Resources\SurveyResponses\Schemas;

use App\Models\Survey\SurveyQuestion;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SurveyResponseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Responden')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('respondent_id')
                                ->label('ID Responden (NIM/NIDN)')
                                ->readOnly(),
                            TextInput::make('respondent_type')
                                ->label('Kategori')
                                ->readOnly(),
                            DateTimePicker::make('submitted_at')
                                ->label('Waktu Pengiriman')
                                ->readOnly(),
                        ]),
                    ]),

                Section::make('Detail Jawaban')
                    ->description('Daftar jawaban yang diberikan untuk setiap pertanyaan survei.')
                    ->schema([
                        Repeater::make('answers')
                            ->relationship('answers')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('survey_question_id')
                                        ->label('Pertanyaan')
                                        ->formatStateUsing(fn ($state) => SurveyQuestion::find($state)?->question_text)
                                        ->columnSpan(1)
                                        ->readOnly(),
                                    
                                    TextInput::make('answer_score')
                                        ->label('Skor/Pilihan')
                                        ->visible(fn ($get) => filled($get('answer_score')))
                                        ->readOnly(),
                                    
                                    TextInput::make('answer_text')
                                        ->label('Jawaban Teks')
                                        ->visible(fn ($get) => filled($get('answer_text')))
                                        ->columnSpanFull()
                                        ->readOnly(),
                                ]),
                            ])
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
