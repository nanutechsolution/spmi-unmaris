<?php

namespace App\Filament\Resources\Ami\AmiCycles\Pages;

use App\Filament\Resources\Ami\AmiCycles\AmiCycleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAmiCycles extends ListRecords
{
    protected static string $resource = AmiCycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
