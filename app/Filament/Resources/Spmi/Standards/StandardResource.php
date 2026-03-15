<?php

namespace App\Filament\Resources\Spmi\Standards;

use App\Filament\Resources\Spmi\Standards\Pages\CreateStandard;
use App\Filament\Resources\Spmi\Standards\Pages\EditStandard;
use App\Filament\Resources\Spmi\Standards\Pages\ListStandards;
use App\Filament\Resources\Spmi\Standards\Schemas\StandardForm;
use App\Filament\Resources\Spmi\Standards\Tables\StandardsTable;
use App\Models\Spmi\Standard;
use App\NavigationGroupEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StandardResource extends Resource
{
    protected static ?string $model = Standard::class;
    protected static string | \UnitEnum | null $navigationGroup = NavigationGroupEnum::MASTER->value;
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Standar Mutu';
    protected static ?string $pluralModelLabel = 'Standar Mutu';
    public static function form(Schema $schema): Schema
    {
        return StandardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StandardsTable::configure($table);
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
            'index' => ListStandards::route('/'),
            'create' => CreateStandard::route('/create'),
            'edit' => EditStandard::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
