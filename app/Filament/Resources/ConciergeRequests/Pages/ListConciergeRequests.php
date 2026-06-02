<?php

namespace App\Filament\Resources\ConciergeRequests\Pages;

use App\Filament\Resources\ConciergeRequests\ConciergeRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConciergeRequests extends ListRecords
{
    protected static string $resource = ConciergeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
