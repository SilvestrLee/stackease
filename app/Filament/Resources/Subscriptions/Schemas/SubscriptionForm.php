<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SubscriptionForm
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

                Select::make('provider_id')
                    ->label('Provider')
                    ->relationship('provider', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('concierge_request_id')
                    ->label('Concierge Request')
                    ->relationship('conciergeRequest', 'request_reference')
                    ->searchable()
                    ->preload(),

                Select::make('invoice_id')
                    ->label('Invoice')
                    ->relationship('invoice', 'invoice_reference')
                    ->searchable()
                    ->preload(),

                TextInput::make('subscription_reference')
                    ->required()
                    ->default(fn () => 'SUB-' . strtoupper(Str::random(8)))
                    ->unique(ignoreRecord: true),

                TextInput::make('provider_name')
                    ->required(),

                TextInput::make('plan_type'),

                TextInput::make('seat_count')
                    ->required()
                    ->numeric()
                    ->default(1),

                DatePicker::make('start_date'),

                DatePicker::make('renewal_date'),

                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('₦'),

                TextInput::make('currency')
                    ->required()
                    ->default('NGN'),

                Select::make('status')
                    ->required()
                    ->options([
                        'pending_setup' => 'Pending Setup',
                        'active' => 'Active',
                        'renewal_due' => 'Renewal Due',
                        'expired' => 'Expired',
                        'suspended' => 'Suspended',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending_setup'),

                Textarea::make('access_note')
                    ->rows(4)
                    ->columnSpanFull(),

                Textarea::make('internal_note')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}