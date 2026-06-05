<?php

namespace App\Filament\Resources\Deals\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DealInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Deal Information')
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('slug'),
                        TextEntry::make('short_description')->placeholder('-'),
                        TextEntry::make('description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Provider & Category')
                    ->schema([
                        TextEntry::make('provider.name')
                            ->label('Provider')
                            ->placeholder('-'),

                        TextEntry::make('category.name')
                            ->label('Category')
                            ->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('Pricing')
                    ->schema([
                        TextEntry::make('regular_price')
                            ->money('USD')
                            ->placeholder('-'),

                        TextEntry::make('deal_price')
                            ->money('USD')
                            ->placeholder('-'),

                        TextEntry::make('discount_percent')
                            ->suffix('%')
                            ->placeholder('-'),
                    ])
                    ->columns(3),

                Section::make('Status & Schedule')
                    ->schema([
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'published' => 'success',
                                'draft' => 'gray',
                                'expired' => 'danger',
                                'archived' => 'warning',
                                default => 'gray',
                            }),

                        IconEntry::make('is_featured')
                            ->label('Featured')
                            ->boolean(),

                        TextEntry::make('badge')
                            ->placeholder('-'),

                        TextEntry::make('deal_url')
                            ->label('External Deal URL')
                            ->placeholder('-'),

                        TextEntry::make('starts_at')
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('expires_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('System Information')
                    ->schema([
                        TextEntry::make('creator.name')
                            ->label('Created By')
                            ->placeholder('-'),

                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(3),
            ]);
    }
}