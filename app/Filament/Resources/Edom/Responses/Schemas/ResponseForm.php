<?php

namespace App\Filament\Resources\Edom\Responses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ResponseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('edom_period_id')
                    ->required()
                    ->numeric(),
                TextInput::make('edom_question_id')
                    ->required()
                    ->numeric(),
                TextInput::make('siakad_student_id')
                    ->required(),
                TextInput::make('siakad_lecturer_id')
                    ->required(),
                TextInput::make('siakad_course_id')
                    ->required(),
                TextInput::make('siakad_class_id')
                    ->required(),
                TextInput::make('score')
                    ->required()
                    ->numeric(),
            ]);
    }
}
