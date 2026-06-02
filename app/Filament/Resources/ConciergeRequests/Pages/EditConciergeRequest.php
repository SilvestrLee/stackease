<?php

namespace App\Filament\Resources\ConciergeRequests\Pages;

use App\Filament\Resources\ConciergeRequests\ConciergeRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditConciergeRequest extends EditRecord
{
    protected static string $resource = ConciergeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
