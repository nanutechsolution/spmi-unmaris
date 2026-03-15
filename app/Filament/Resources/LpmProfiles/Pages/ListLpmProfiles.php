<?php

namespace App\Filament\Resources\LpmProfiles\Pages;

use App\Filament\Resources\LpmProfiles\LpmProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLpmProfiles extends ListRecords
{
    protected static string $resource = LpmProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
