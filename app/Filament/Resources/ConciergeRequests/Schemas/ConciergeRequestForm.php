<?php

namespace App\Filament\Resources\ConciergeRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ConciergeRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('provider_id')
                    ->relationship('provider', 'name'),
                Select::make('batch_window_id')
                    ->relationship('batchWindow', 'name'),
                TextInput::make('request_reference')
                    ->required(),
                TextInput::make('service_name')
                    ->required(),
                TextInput::make('request_type')
                    ->required()
                    ->default('subscription_setup'),
                TextInput::make('desired_plan'),
                TextInput::make('seat_count')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('duration'),
                TextInput::make('budget_range'),
                Toggle::make('existing_account')
                    ->required(),
                Textarea::make('issue_description')
                    ->columnSpanFull(),
                Textarea::make('user_notes')
                    ->columnSpanFull(),
                Textarea::make('admin_notes')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('submitted'),
                TextInput::make('priority')
                    ->required()
                    ->default('normal'),
                DateTimePicker::make('reviewed_at'),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
