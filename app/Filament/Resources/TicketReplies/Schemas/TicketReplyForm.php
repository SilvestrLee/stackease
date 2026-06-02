<?php

namespace App\Filament\Resources\TicketReplies\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TicketReplyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('support_ticket_id')
                    ->label('Support Ticket')
                    ->relationship('supportTicket', 'ticket_reference')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('user_id')
                    ->label('Reply Author')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('message')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                Toggle::make('is_internal_note')
                    ->label('Internal Note')
                    ->default(false),

                Textarea::make('attachments')
                    ->helperText('Temporary text field for attachment references. File upload can be added later.')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}