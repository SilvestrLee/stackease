<?php

namespace App\Filament\Resources\Deals\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DealForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Deal Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set): void {
                                if ($operation === 'create' && filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('short_description')
                            ->maxLength(255),

                        Textarea::make('description')
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Provider & Category')
                    ->schema([
                        Select::make('provider_id')
                            ->label('Provider')
                            ->relationship('provider', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Section::make('Pricing')
                    ->schema([
                        TextInput::make('regular_price')
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0),

                        TextInput::make('deal_price')
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0),

                        TextInput::make('discount_percent')
                            ->numeric()
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100),
                    ])
                    ->columns(3),

                Section::make('Deal Settings')
                    ->schema([
                        TextInput::make('deal_url')
                            ->label('External Deal URL')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('badge')
                            ->placeholder('Featured, Limited Time, Popular')
                            ->maxLength(255),

                        Select::make('status')
                            ->required()
                            ->default('draft')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'expired' => 'Expired',
                                'archived' => 'Archived',
                            ]),

                        Toggle::make('is_featured')
                            ->label('Feature this deal')
                            ->default(false),
                    ])
                    ->columns(2),

                Section::make('Schedule')
                    ->schema([
                        DateTimePicker::make('starts_at'),

                        DateTimePicker::make('expires_at'),
                    ])
                    ->columns(2),
            ]);
    }
}