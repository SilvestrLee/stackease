<?php

namespace App\Filament\Resources\BatchWindows;

use App\Filament\Resources\BatchWindows\Pages\CreateBatchWindow;
use App\Filament\Resources\BatchWindows\Pages\EditBatchWindow;
use App\Filament\Resources\BatchWindows\Pages\ListBatchWindows;
use App\Filament\Resources\BatchWindows\Schemas\BatchWindowForm;
use App\Filament\Resources\BatchWindows\Tables\BatchWindowsTable;
use App\Models\BatchWindow;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BatchWindowResource extends Resource
{
    protected static ?string $model = BatchWindow::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BatchWindowForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BatchWindowsTable::configure($table);
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
            'index' => ListBatchWindows::route('/'),
            'create' => CreateBatchWindow::route('/create'),
            'edit' => EditBatchWindow::route('/{record}/edit'),
        ];
    }
}
