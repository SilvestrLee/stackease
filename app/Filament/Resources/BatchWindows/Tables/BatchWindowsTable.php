<?php

namespace App\Filament\Resources\BatchWindows\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BatchWindowsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('cutoff_time')
                    ->label('Cutoff')
                    ->time()
                    ->sortable(),

                TextColumn::make('fulfillment_start_time')
                    ->label('Starts')
                    ->time()
                    ->sortable(),

                TextColumn::make('fulfillment_end_time')
                    ->label('Ends')
                    ->time()
                    ->sortable(),

                TextColumn::make('capacity_limit')
                    ->label('Capacity')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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