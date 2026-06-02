<?php

namespace App\Filament\Resources\ConciergeRequests\RelationManagers;

use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';

    protected static ?string $relatedResource = InvoiceResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}