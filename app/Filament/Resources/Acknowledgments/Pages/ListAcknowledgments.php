<?php

namespace App\Filament\Resources\Acknowledgments\Pages;

use App\Filament\Resources\Acknowledgments\AcknowledgmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAcknowledgments extends ListRecords
{
    protected static string $resource = AcknowledgmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
