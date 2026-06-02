<?php

namespace App\Filament\Resources\AuditLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuditLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('actor.name')
                    ->label('Actor')
                    ->searchable(),

                TextColumn::make('action')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('target_type')
                    ->label('Target')
                    ->searchable(),

                TextColumn::make('target_id')
                    ->label('Target ID')
                    ->sortable(),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Logged At')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}