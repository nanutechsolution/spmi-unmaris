<?php

namespace App\Filament\Resources\Ami\AmiSchedules;

use App\Filament\Resources\Ami\AmiSchedules\Pages\CreateAmiSchedule;
use App\Filament\Resources\Ami\AmiSchedules\Pages\EditAmiSchedule;
use App\Filament\Resources\Ami\AmiSchedules\Pages\ListAmiSchedules;
use App\Filament\Resources\Ami\AmiSchedules\Schemas\AmiScheduleForm;
use App\Filament\Resources\Ami\AmiSchedules\Tables\AmiSchedulesTable;
use App\Models\Ami\Schedule;
use App\NavigationGroupEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AmiScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    
    protected static string | \UnitEnum | null $navigationGroup = NavigationGroupEnum::AMI->value;
    protected static ?string $modelLabel = 'Jadwal & Temuan Audit';
    protected static ?string $pluralModelLabel = 'Jadwal & Temuan Audit';
    protected static ?int $navigationSort = 2;
    public static function form(Schema $schema): Schema
    {
        return AmiScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AmiSchedulesTable::configure($table);
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
            'index' => ListAmiSchedules::route('/'),
            'create' => CreateAmiSchedule::route('/create'),
            'edit' => EditAmiSchedule::route('/{record}/edit'),
        ];
    }
}
