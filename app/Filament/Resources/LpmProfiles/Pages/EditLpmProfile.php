<?php

namespace App\Filament\Resources\LpmProfiles\Pages;

use App\Filament\Resources\LpmProfiles\LpmProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLpmProfile extends EditRecord
{
    protected static string $resource = LpmProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
