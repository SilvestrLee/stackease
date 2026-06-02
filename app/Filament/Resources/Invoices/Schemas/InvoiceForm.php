<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class InvoiceForm
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

                TextInput::make('invoice_reference')
                    ->required()
                    ->default(fn () => 'INV-' . strtoupper(Str::random(8)))
                    ->unique(ignoreRecord: true),

                TextInput::make('base_usd_cost')
                    ->label('Base USD Cost')
                    ->numeric()
                    ->default(0)
                    ->prefix('$')
                    ->required(),

                TextInput::make('fx_rate')
                    ->label('FX Rate')
                    ->numeric()
                    ->default(0)
                    ->prefix('₦')
                    ->required(),

                TextInput::make('fx_buffer_percent')
                    ->label('FX Buffer %')
                    ->numeric()
                    ->default(10)
                    ->suffix('%')
                    ->required(),

                TextInput::make('fx_buffer_amount')
                    ->label('FX Buffer Amount')
                    ->numeric()
                    ->default(0)
                    ->prefix('₦')
                    ->required(),

                TextInput::make('service_fee')
                    ->label('Service Fee')
                    ->numeric()
                    ->default(0)
                    ->prefix('₦')
                    ->required(),

                TextInput::make('gateway_fee')
                    ->label('Gateway Fee')
                    ->numeric()
                    ->default(0)
                    ->prefix('₦')
                    ->required(),

                TextInput::make('total_naira_amount')
                    ->label('Total Naira Amount')
                    ->numeric()
                    ->default(0)
                    ->prefix('₦')
                    ->required(),

                TextInput::make('currency')
                    ->required()
                    ->default('NGN'),

                Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'awaiting_payment' => 'Awaiting Payment',
                        'paid' => 'Paid',
                        'expired' => 'Expired',
                        'cancelled' => 'Cancelled',
                        'refunded' => 'Refunded',
                    ])
                    ->default('draft'),

                DateTimePicker::make('sent_at'),

                DateTimePicker::make('expires_at'),

                DateTimePicker::make('paid_at'),

                Textarea::make('notes')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}