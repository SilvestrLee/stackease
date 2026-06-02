<?php

namespace App\Filament\Resources\SubscriptionCredentials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubscriptionCredentialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subscription.subscription_reference')
                    ->label('Subscription')
                    ->searchable(),

                TextColumn::make('payload_type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('lastViewedBy.name')
                    ->label('Last Viewed By')
                    ->searchable(),

                TextColumn::make('last_viewed_at')
                    ->label('Last Viewed')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}