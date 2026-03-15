<?php

namespace App\Filament\Resources\Edom\Questions;

use App\Filament\Resources\Edom\Questions\Pages\CreateQuestion;
use App\Filament\Resources\Edom\Questions\Pages\EditQuestion;
use App\Filament\Resources\Edom\Questions\Pages\ListQuestions;
use App\Filament\Resources\Edom\Questions\Schemas\QuestionForm;
use App\Filament\Resources\Edom\Questions\Tables\QuestionsTable;
use App\Models\Survey\Question;
use App\NavigationGroupEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static string | \UnitEnum | null $navigationGroup = NavigationGroupEnum::EDOM->value;
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return QuestionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestions::route('/'),
            'create' => CreateQuestion::route('/create'),
            'edit' => EditQuestion::route('/{record}/edit'),
        ];
    }
}
