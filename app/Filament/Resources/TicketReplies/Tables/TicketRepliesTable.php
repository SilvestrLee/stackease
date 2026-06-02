<?php

namespace App\Filament\Resources\TicketReplies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketRepliesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supportTicket.ticket_reference')
                    ->label('Ticket')
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Author')
                    ->searchable(),

                TextColumn::make('message')
                    ->limit(50)
                    ->searchable(),

                IconColumn::make('is_internal_note')
                    ->label('Internal')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Replied At')
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