<?php

namespace App\Filament\Resources\Ami\AmiSchedules\Pages;

use App\Filament\Resources\Ami\AmiSchedules\AmiScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAmiSchedules extends ListRecords
{
    protected static string $resource = AmiScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
