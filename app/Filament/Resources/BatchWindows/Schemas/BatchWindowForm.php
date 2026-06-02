<?php

namespace App\Filament\Resources\BatchWindows\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class BatchWindowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->placeholder('Morning Batch'),

                TimePicker::make('cutoff_time')
                    ->required(),

                TimePicker::make('fulfillment_start_time')
                    ->required(),

                TimePicker::make('fulfillment_end_time')
                    ->required(),

                TextInput::make('timezone')
                    ->required()
                    ->default('Africa/Lagos'),

                TextInput::make('capacity_limit')
                    ->numeric()
                    ->minValue(1),

                Select::make('status')
                    ->required()
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active'),
            ]);
    }
}