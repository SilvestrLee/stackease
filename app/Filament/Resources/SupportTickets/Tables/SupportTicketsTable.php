<?php

namespace App\Filament\Resources\SupportTickets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SupportTicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_reference')
                    ->label('Ticket')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('subject')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('ticket_type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('priority')
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('assignedAgent.name')
                    ->label('Assigned To')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Opened')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('resolved_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('closed_at')
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