<?php

namespace App\Filament\Resources\SupportTickets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SupportTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Customer')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('concierge_request_id')
                    ->label('Concierge Request')
                    ->relationship('conciergeRequest', 'request_reference')
                    ->searchable()
                    ->preload(),

                Select::make('subscription_id')
                    ->label('Subscription')
                    ->relationship('subscription', 'subscription_reference')
                    ->searchable()
                    ->preload(),

                TextInput::make('ticket_reference')
                    ->required()
                    ->default(fn () => 'TKT-' . strtoupper(Str::random(8)))
                    ->unique(ignoreRecord: true),

                TextInput::make('subject')
                    ->required(),

                Textarea::make('message')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                Select::make('ticket_type')
                    ->required()
                    ->options([
                        'payment_issue' => 'Payment Issue',
                        'setup_issue' => 'Setup Issue',
                        'access_issue' => 'Access Issue',
                        'renewal_issue' => 'Renewal Issue',
                        'refund_request' => 'Refund Request',
                        'provider_downtime' => 'Provider Downtime',
                        'general' => 'General Question',
                    ])
                    ->default('general'),

                Select::make('priority')
                    ->required()
                    ->options([
                        'low' => 'Low',
                        'normal' => 'Normal',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ])
                    ->default('normal'),

                Select::make('status')
                    ->required()
                    ->options([
                        'open' => 'Open',
                        'awaiting_user' => 'Awaiting User',
                        'awaiting_admin' => 'Awaiting Admin',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                    ])
                    ->default('open'),

                Select::make('assigned_to')
                    ->label('Assigned To')
                    ->relationship('assignedAgent', 'name')
                    ->searchable()
                    ->preload(),

                DateTimePicker::make('resolved_at'),

                DateTimePicker::make('closed_at'),
            ]);
    }
}