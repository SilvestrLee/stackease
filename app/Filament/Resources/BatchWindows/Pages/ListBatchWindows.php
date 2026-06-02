<?php

namespace App\Filament\Resources\BatchWindows\Pages;

use App\Filament\Resources\BatchWindows\BatchWindowResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBatchWindows extends ListRecords
{
    protected static string $resource = BatchWindowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
