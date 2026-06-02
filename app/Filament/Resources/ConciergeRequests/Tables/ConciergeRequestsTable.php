<?php

namespace App\Filament\Resources\ConciergeRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConciergeRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('request_reference')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('provider.name')
                    ->label('Provider')
                    ->searchable(),

                TextColumn::make('service_name')
                    ->label('Service')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('request_type')
                    ->label('Type')
                    ->searchable(),

                TextColumn::make('seat_count')
                    ->label('Seats')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('existing_account')
                    ->label('Existing Account')
                    ->boolean(),

                TextColumn::make('status')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('priority')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Submitted')
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