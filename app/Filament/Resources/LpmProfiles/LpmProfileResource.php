<?php

namespace App\Filament\Resources\LpmProfiles;

use App\Filament\Resources\LpmProfiles\Pages\CreateLpmProfile;
use App\Filament\Resources\LpmProfiles\Pages\EditLpmProfile;
use App\Filament\Resources\LpmProfiles\Pages\ListLpmProfiles;
use App\Filament\Resources\LpmProfiles\Schemas\LpmProfileForm;
use App\Filament\Resources\LpmProfiles\Tables\LpmProfilesTable;
use App\Models\LpmProfile;
use App\NavigationGroupEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LpmProfileResource extends Resource
{
    protected static ?string $model = LpmProfile::class;

    protected static string | \UnitEnum | null $navigationGroup = NavigationGroupEnum::PORTAL->value;

    protected static ?string $modelLabel = 'Profil Website LPM';

    protected static ?string $pluralModelLabel = 'Profil Website LPM';

    protected static ?int $navigationSort = 10;
    protected static ?string $recordTitleAttribute = 'name';

    public static function canCreate(): bool
    {
        return LpmProfile::count() === 0;
    }

    public static function form(Schema $schema): Schema
    {
        return LpmProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LpmProfilesTable::configure($table);
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
            'index' => ListLpmProfiles::route('/'),
            'create' => CreateLpmProfile::route('/create'),
            'edit' => EditLpmProfile::route('/{record}/edit'),
        ];
    }
}
