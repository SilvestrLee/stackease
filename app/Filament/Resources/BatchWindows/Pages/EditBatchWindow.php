<?php

namespace App\Filament\Resources\BatchWindows\Pages;

use App\Filament\Resources\BatchWindows\BatchWindowResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBatchWindow extends EditRecord
{
    protected static string $resource = BatchWindowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
