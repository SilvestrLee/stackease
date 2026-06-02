<?php

namespace App\Filament\Resources\Acknowledgments;

use App\Filament\Resources\Acknowledgments\Pages\CreateAcknowledgment;
use App\Filament\Resources\Acknowledgments\Pages\EditAcknowledgment;
use App\Filament\Resources\Acknowledgments\Pages\ListAcknowledgments;
use App\Filament\Resources\Acknowledgments\Schemas\AcknowledgmentForm;
use App\Filament\Resources\Acknowledgments\Tables\AcknowledgmentsTable;
use App\Models\Acknowledgment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AcknowledgmentResource extends Resource
{
    protected static ?string $model = Acknowledgment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'acknowledgment_reference';

    public static function form(Schema $schema): Schema
    {
        return AcknowledgmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AcknowledgmentsTable::configure($table);
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
            'index' => ListAcknowledgments::route('/'),
            'create' => CreateAcknowledgment::route('/create'),
            'edit' => EditAcknowledgment::route('/{record}/edit'),
        ];
    }
}
