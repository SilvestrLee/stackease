<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PaymentForm
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

                Select::make('invoice_id')
                    ->label('Invoice')
                    ->relationship('invoice', 'invoice_reference')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('payment_reference')
                    ->required()
                    ->default(fn () => 'PAY-' . strtoupper(Str::random(10)))
                    ->unique(ignoreRecord: true),

                Select::make('gateway')
                    ->required()
                    ->options([
                        'paystack' => 'Paystack',
                        'flutterwave' => 'Flutterwave',
                        'bank_transfer' => 'Bank Transfer',
                        'manual' => 'Manual',
                    ])
                    ->default('manual'),

                TextInput::make('amount')
                    ->required()
                    ->numeric(),

                TextInput::make('currency')
                    ->required()
                    ->default('NGN'),

                Select::make('status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                        'refunded' => 'Refunded',
                    ])
                    ->default('pending'),

                TextInput::make('payment_channel')
                    ->default('manual_admin_entry'),

                TextInput::make('proof_of_payment_path'),

                TextInput::make('gateway_response'),

                DateTimePicker::make('paid_at'),

                TextInput::make('verified_by')
                    ->numeric(),

                DateTimePicker::make('verified_at'),
            ]);
    }
}