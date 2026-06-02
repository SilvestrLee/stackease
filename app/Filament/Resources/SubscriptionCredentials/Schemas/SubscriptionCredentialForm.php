<?php

namespace App\Filament\Resources\SubscriptionCredentials\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SubscriptionCredentialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subscription_id')
                    ->label('Subscription')
                    ->relationship('subscription', 'subscription_reference')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('payload_type')
                    ->required()
                    ->options([
                        'invitation_link' => 'Invitation Link',
                        'setup_instruction' => 'Setup Instruction',
                        'workspace_link' => 'Workspace Link',
                        'access_note' => 'Access Note',
                        'other' => 'Other',
                    ])
                    ->default('invitation_link'),

                Textarea::make('encrypted_access_payload')
                    ->label('Access Payload')
                    ->helperText('For now, paste access/setup details here. Encryption handling will be improved in the secure access phase.')
                    ->rows(6)
                    ->columnSpanFull(),

                DateTimePicker::make('last_viewed_at')
                    ->disabled(),

                Select::make('last_viewed_by')
                    ->label('Last Viewed By')
                    ->relationship('lastViewedBy', 'name')
                    ->searchable()
                    ->preload()
                    ->disabled(),
            ]);
    }
}