<?php

namespace App\Filament\Resources\ConciergeRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ConciergeRequestForm
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

                Select::make('batch_window_id')
                    ->label('Batch Window')
                    ->relationship('batchWindow', 'name')
                    ->searchable()
                    ->preload(),

                TextInput::make('request_reference')
                    ->required()
                    ->default(fn () => 'REQ-' . strtoupper(Str::random(8)))
                    ->unique(ignoreRecord: true),

                TextInput::make('service_name')
                    ->required(),

                Select::make('request_type')
                    ->required()
                    ->options([
                        'subscription_setup' => 'Subscription Setup',
                        'subscription_payment' => 'Subscription Payment',
                        'renewal' => 'Renewal',
                        'workspace_setup' => 'Workspace Setup',
                        'support' => 'Support',
                        'other' => 'Other',
                    ])
                    ->default('subscription_setup'),

                TextInput::make('desired_plan'),

                TextInput::make('seat_count')
                    ->required()
                    ->numeric()
                    ->default(1),

                TextInput::make('duration'),

                TextInput::make('budget_range'),

                Toggle::make('existing_account')
                    ->label('Customer already has an account?')
                    ->default(false),

                Textarea::make('issue_description')
                    ->columnSpanFull(),

                Textarea::make('user_notes')
                    ->columnSpanFull(),

                Textarea::make('admin_notes')
                    ->columnSpanFull(),

                Select::make('status')
                    ->required()
                    ->options([
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'quote_sent' => 'Quote Sent',
                        'awaiting_payment' => 'Awaiting Payment',
                        'payment_confirmed' => 'Payment Confirmed',
                        'in_progress' => 'In Progress',
                        'setup_completed' => 'Setup Completed',
                        'active' => 'Active',
                        'cancelled' => 'Cancelled',
                        'rejected' => 'Rejected',
                    ])
                    ->default('submitted'),

                Select::make('priority')
                    ->required()
                    ->options([
                        'low' => 'Low',
                        'normal' => 'Normal',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ])
                    ->default('normal'),

                DateTimePicker::make('reviewed_at'),

                DateTimePicker::make('completed_at'),
            ]);
    }
}