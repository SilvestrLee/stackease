<?php

namespace App\Filament\Resources\SubscriptionCredentials\Pages;

use App\Filament\Resources\SubscriptionCredentials\SubscriptionCredentialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptionCredentials extends ListRecords
{
    protected static string $resource = SubscriptionCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
