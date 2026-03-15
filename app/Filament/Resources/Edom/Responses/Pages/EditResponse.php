<?php

namespace App\Filament\Resources\Edom\Responses\Pages;

use App\Filament\Resources\Edom\Responses\ResponseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditResponse extends EditRecord
{
    protected static string $resource = ResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
