<?php

namespace App\Filament\Resources\Rtms\Pages;

use App\Filament\Resources\Rtms\RtmResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRtm extends EditRecord
{
    protected static string $resource = RtmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
