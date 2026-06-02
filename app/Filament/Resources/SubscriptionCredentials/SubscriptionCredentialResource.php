<?php

namespace App\Filament\Resources\SubscriptionCredentials;

use App\Filament\Resources\SubscriptionCredentials\Pages\CreateSubscriptionCredential;
use App\Filament\Resources\SubscriptionCredentials\Pages\EditSubscriptionCredential;
use App\Filament\Resources\SubscriptionCredentials\Pages\ListSubscriptionCredentials;
use App\Filament\Resources\SubscriptionCredentials\Schemas\SubscriptionCredentialForm;
use App\Filament\Resources\SubscriptionCredentials\Tables\SubscriptionCredentialsTable;
use App\Models\SubscriptionCredential;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SubscriptionCredentialResource extends Resource
{
    protected static ?string $model = SubscriptionCredential::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Subscriptions';

    protected static ?int $navigationSort = 4;
    
    protected static ?string $recordTitleAttribute = 'payload_type';

    public static function form(Schema $schema): Schema
    {
        return SubscriptionCredentialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscriptionCredentialsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptionCredentials::route('/'),
            'create' => CreateSubscriptionCredential::route('/create'),
            'edit' => EditSubscriptionCredential::route('/{record}/edit'),
        ];
    }
}
