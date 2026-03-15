<?php

namespace App\Filament\Resources\SurveyResponses;

use App\Filament\Resources\SurveyResponses\Pages\CreateSurveyResponse;
use App\Filament\Resources\SurveyResponses\Pages\EditSurveyResponse;
use App\Filament\Resources\SurveyResponses\Pages\ListSurveyResponses;
use App\Filament\Resources\SurveyResponses\Schemas\SurveyResponseForm;
use App\Filament\Resources\SurveyResponses\Tables\SurveyResponsesTable;
use App\Models\Survey\Response;
use App\NavigationGroupEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SurveyResponseResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static string | \UnitEnum | null $navigationGroup = NavigationGroupEnum::PORTAL->value;

    protected static ?string $modelLabel = 'Hasil Survei';

    protected static ?string $pluralModelLabel = 'Data Responden';

    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SurveyResponseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurveyResponsesTable::configure($table);
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
            'index' => ListSurveyResponses::route('/'),
            'create' => CreateSurveyResponse::route('/create'),
            'edit' => EditSurveyResponse::route('/{record}/edit'),
        ];
    }
}
