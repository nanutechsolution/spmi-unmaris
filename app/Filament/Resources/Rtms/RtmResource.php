<?php

namespace App\Filament\Resources\Rtms;

use App\Filament\Resources\Rtms\Pages\CreateRtm;
use App\Filament\Resources\Rtms\Pages\EditRtm;
use App\Filament\Resources\Rtms\Pages\ListRtms;
use App\Filament\Resources\Rtms\Schemas\RtmForm;
use App\Filament\Resources\Rtms\Tables\RtmsTable;
use App\Models\Ami\Rtm;
use App\NavigationGroupEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class RtmResource extends Resource
{
    protected static ?string $model = Rtm::class;

    protected static string | \UnitEnum | null $navigationGroup = NavigationGroupEnum::MASTER->value;
    protected static ?string $modelLabel = 'Rapat Tinjauan Manajemen';

    protected static ?string $pluralModelLabel = 'RTM';

    protected static ?int $navigationSort = 3;
    public static function form(Schema $schema): Schema
    {
        return RtmForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RtmsTable::configure($table);
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
            'index' => ListRtms::route('/'),
            'create' => CreateRtm::route('/create'),
            'edit' => EditRtm::route('/{record}/edit'),
        ];
    }
}
