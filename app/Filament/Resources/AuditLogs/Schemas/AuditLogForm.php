<?php

namespace App\Filament\Resources\AuditLogs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AuditLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('actor_id')
                    ->relationship('actor', 'name'),
                TextInput::make('action')
                    ->required(),
                TextInput::make('target_type'),
                TextInput::make('target_id')
                    ->numeric(),
                TextInput::make('old_values'),
                TextInput::make('new_values'),
                TextInput::make('ip_address'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
            ]);
    }
}
