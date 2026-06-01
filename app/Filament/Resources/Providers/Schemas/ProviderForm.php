<?php

namespace App\Filament\Resources\Providers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('website_url')
                    ->label('Website URL')
                    ->url()
                    ->placeholder('https://example.com'),

                Select::make('provider_type')
                    ->required()
                    ->options([
                        'productivity' => 'Productivity',
                        'communication' => 'Communication',
                        'design' => 'Design',
                        'storage' => 'Storage',
                        'security' => 'Security / VPN',
                        'business' => 'Business Tools',
                        'other' => 'Other',
                    ])
                    ->default('productivity'),

                Select::make('risk_level')
                    ->required()
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'critical' => 'Critical',
                    ])
                    ->default('low'),

                Select::make('allowed_status')
                    ->required()
                    ->options([
                        'approved' => 'Approved',
                        'deal_only' => 'Deal Only',
                        'review_required' => 'Review Required',
                        'restricted' => 'Restricted',
                        'barred' => 'Barred',
                    ])
                    ->default('approved'),

                Select::make('status')
                    ->required()
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active'),

                Textarea::make('description')
                    ->rows(4)
                    ->columnSpanFull(),

                Textarea::make('admin_notes')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}