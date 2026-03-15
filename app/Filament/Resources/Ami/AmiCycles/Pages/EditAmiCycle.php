<?php

namespace App\Filament\Resources\Ami\AmiCycles\Pages;

use App\Filament\Resources\Ami\AmiCycles\AmiCycleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAmiCycle extends EditRecord
{
    protected static string $resource = AmiCycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
