<?php

namespace App\Filament\Resources\Providers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProvidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('provider_type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('risk_level')
                    ->label('Risk')
                    ->badge()
                    ->sortable(),

                TextColumn::make('allowed_status')
                    ->label('Allowed')
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('website_url')
                    ->label('Website')
                    ->limit(30)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('provider_type')
                    ->options([
                        'productivity' => 'Productivity',
                        'communication' => 'Communication',
                        'design' => 'Design',
                        'storage' => 'Storage',
                        'security' => 'Security / VPN',
                        'business' => 'Business Tools',
                        'other' => 'Other',
                    ]),

                SelectFilter::make('risk_level')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'critical' => 'Critical',
                    ]),

                SelectFilter::make('allowed_status')
                    ->options([
                        'approved' => 'Approved',
                        'deal_only' => 'Deal Only',
                        'review_required' => 'Review Required',
                        'restricted' => 'Restricted',
                        'barred' => 'Barred',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}