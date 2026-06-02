<?php

namespace App\Filament\Resources\Acknowledgments\Pages;

use App\Filament\Resources\Acknowledgments\AcknowledgmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAcknowledgment extends EditRecord
{
    protected static string $resource = AcknowledgmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
