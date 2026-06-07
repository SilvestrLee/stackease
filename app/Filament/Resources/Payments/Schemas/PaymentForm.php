<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
                    ->label('Payment Channel')
                    ->default('manual_admin_entry')
                    ->disabled()
                    ->dehydrated(),

                FileUpload::make('proof_of_payment_path')
                    ->label('Proof of Payment')
                    ->disk('public')
                    ->directory('payment-proofs')
                    ->openable()
                    ->downloadable()
                    ->previewable()
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                        'application/pdf',
                    ])
                    ->maxSize(5120)
                    ->helperText('Uploaded proof file. You can open or download it from here.'),

                Textarea::make('gateway_response')
                    ->label('Gateway Response')
                    ->formatStateUsing(function ($state) {
                        if (blank($state)) {
                            return null;
                        }

                        if (is_array($state)) {
                            return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                        }

                        if (is_object($state)) {
                            return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                        }

                        $decoded = json_decode($state, true);

                        if (json_last_error() === JSON_ERROR_NONE) {
                            return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                        }

                        return $state;
                    })
                    ->rows(5)
                    ->disabled()
                    ->dehydrated(false),

                DateTimePicker::make('paid_at')
                    ->label('Paid At'),

                Select::make('verified_by')
                    ->label('Verified By')
                    ->relationship('verifier', 'name')
                    ->searchable()
                    ->preload()
                    ->disabled()
                    ->dehydrated(false),

                DateTimePicker::make('verified_at')
                    ->label('Verified At')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }
}