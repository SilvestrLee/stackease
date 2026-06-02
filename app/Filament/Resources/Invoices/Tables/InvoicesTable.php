<?php

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_reference')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('conciergeRequest.request_reference')
                    ->label('Request')
                    ->searchable(),

                TextColumn::make('base_usd_cost')
                    ->label('USD Cost')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('fx_rate')
                    ->label('FX Rate')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('service_fee')
                    ->label('Service Fee')
                    ->money('NGN')
                    ->sortable(),

                TextColumn::make('total_naira_amount')
                    ->label('Total')
                    ->money('NGN')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
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