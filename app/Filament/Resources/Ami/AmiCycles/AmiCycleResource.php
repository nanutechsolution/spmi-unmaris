<?php

namespace App\Filament\Resources\Ami\AmiCycles;

use App\Filament\Resources\Ami\AmiCycles\Pages\CreateAmiCycle;
use App\Filament\Resources\Ami\AmiCycles\Pages\EditAmiCycle;
use App\Filament\Resources\Ami\AmiCycles\Pages\ListAmiCycles;
use App\Filament\Resources\Ami\AmiCycles\Schemas\AmiCycleForm;
use App\Filament\Resources\Ami\AmiCycles\Tables\AmiCyclesTable;
use App\Models\Ami\AmiCycle;
use App\Models\Ami\Cycle;
use App\NavigationGroupEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AmiCycleResource extends Resource
{
    protected static ?string $model = Cycle::class;

    protected static ?string $modelLabel = 'Siklus AMI';
    protected static ?string $pluralModelLabel = 'Siklus AMI';
    protected static ?int $navigationSort = 10;
    protected static ?string $recordTitleAttribute = 'name';
    protected static string | \UnitEnum | null $navigationGroup = NavigationGroupEnum::AMI->value;


    public static function form(Schema $schema): Schema
    {
        return AmiCycleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AmiCyclesTable::configure($table);
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
            'index' => ListAmiCycles::route('/'),
            'create' => CreateAmiCycle::route('/create'),
            'edit' => EditAmiCycle::route('/{record}/edit'),
        ];
    }
}
