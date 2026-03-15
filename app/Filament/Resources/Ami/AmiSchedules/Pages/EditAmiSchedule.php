<?php

namespace App\Filament\Resources\Ami\AmiSchedules\Pages;

use App\Filament\Resources\Ami\AmiSchedules\AmiScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAmiSchedule extends EditRecord
{
    protected static string $resource = AmiScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
