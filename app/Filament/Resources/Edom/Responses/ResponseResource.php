<?php

namespace App\Filament\Resources\Edom\Responses;

use App\Filament\Resources\Edom\Responses\Pages\CreateResponse;
use App\Filament\Resources\Edom\Responses\Pages\EditResponse;
use App\Filament\Resources\Edom\Responses\Pages\ListResponses;
use App\Filament\Resources\Edom\Responses\Schemas\ResponseForm;
use App\Filament\Resources\Edom\Responses\Tables\ResponsesTable;
use App\Models\Edom\Response;
use App\NavigationGroupEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ResponseResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static string | \UnitEnum | null $navigationGroup = NavigationGroupEnum::EDOM->value;
    protected static ?string $modelLabel = 'Data Hasil Evaluasi';
    protected static ?string $pluralModelLabel = 'Hasil Evaluasi';
    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ResponseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResponsesTable::configure($table);
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
            'index' => ListResponses::route('/'),
            'create' => CreateResponse::route('/create'),
            'edit' => EditResponse::route('/{record}/edit'),
        ];
    }
}
