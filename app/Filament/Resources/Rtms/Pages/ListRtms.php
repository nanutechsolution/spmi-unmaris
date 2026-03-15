<?php

namespace App\Filament\Resources\Rtms\Pages;

use App\Filament\Resources\Rtms\RtmResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRtms extends ListRecords
{
    protected static string $resource = RtmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
