<?php

namespace App\Filament\Resources\SubscriptionCredentials\Pages;

use App\Filament\Resources\SubscriptionCredentials\SubscriptionCredentialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionCredential extends EditRecord
{
    protected static string $resource = SubscriptionCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
