<?php

namespace App\Filament\Resources\ConciergeRequests;

use App\Filament\Resources\ConciergeRequests\Pages\CreateConciergeRequest;
use App\Filament\Resources\ConciergeRequests\Pages\EditConciergeRequest;
use App\Filament\Resources\ConciergeRequests\Pages\ListConciergeRequests;
use App\Filament\Resources\ConciergeRequests\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\ConciergeRequests\Schemas\ConciergeRequestForm;
use App\Filament\Resources\ConciergeRequests\Tables\ConciergeRequestsTable;
use App\Models\ConciergeRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConciergeRequestResource extends Resource
{
    protected static ?string $model = ConciergeRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'request_reference';

    public static function form(Schema $schema): Schema
    {
        return ConciergeRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConciergeRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InvoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConciergeRequests::route('/'),
            'create' => CreateConciergeRequest::route('/create'),
            'edit' => EditConciergeRequest::route('/{record}/edit'),
        ];
    }
}