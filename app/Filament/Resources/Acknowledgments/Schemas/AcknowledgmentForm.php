<?php

namespace App\Filament\Resources\Acknowledgments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AcknowledgmentForm
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
                    ->preload(),

                Select::make('subscription_id')
                    ->label('Subscription')
                    ->relationship('subscription', 'subscription_reference')
                    ->searchable()
                    ->preload(),

                Select::make('acknowledgment_type')
                    ->required()
                    ->options([
                        'setup_access' => 'Setup Access',
                        'terms_acceptance' => 'Terms Acceptance',
                        'subscription_policy' => 'Subscription Policy',
                        'refund_policy' => 'Refund Policy',
                    ])
                    ->default('setup_access'),

                TextInput::make('terms_version')
                    ->required()
                    ->default('v1.0'),

                Textarea::make('acknowledgment_text')
                    ->rows(5)
                    ->columnSpanFull(),

                DateTimePicker::make('accepted_at'),

                TextInput::make('ip_address'),

                Textarea::make('user_agent')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}