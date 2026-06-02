<?php

namespace App\Filament\Resources\Acknowledgments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AcknowledgmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('invoice.invoice_reference')
                    ->label('Invoice')
                    ->searchable(),

                TextColumn::make('subscription.subscription_reference')
                    ->label('Subscription')
                    ->searchable(),

                TextColumn::make('acknowledgment_type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('terms_version')
                    ->label('Terms')
                    ->searchable(),

                TextColumn::make('accepted_at')
                    ->label('Accepted')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),

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