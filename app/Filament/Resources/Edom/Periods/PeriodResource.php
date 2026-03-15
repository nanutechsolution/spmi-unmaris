<?php

namespace App\Filament\Resources\Edom\Periods;

use App\Filament\Resources\Edom\Periods\Pages\CreatePeriod;
use App\Filament\Resources\Edom\Periods\Pages\EditPeriod;
use App\Filament\Resources\Edom\Periods\Pages\ListPeriods;
use App\Filament\Resources\Edom\Periods\Schemas\PeriodForm;
use App\Filament\Resources\Edom\Periods\Tables\PeriodsTable;
use App\Models\Edom\Period;
use App\NavigationGroupEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PeriodResource extends Resource
{
    protected static ?string $model = Period::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;
    protected static ?string $label = 'Periode Evaluasi';
    protected static ?string $recordTitleAttribute = 'name';
    protected static string | \UnitEnum | null $navigationGroup = NavigationGroupEnum::EDOM->value;
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PeriodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeriodsTable::configure($table);
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
            'index' => ListPeriods::route('/'),
            'create' => CreatePeriod::route('/create'),
            'edit' => EditPeriod::route('/{record}/edit'),
        ];
    }
}
