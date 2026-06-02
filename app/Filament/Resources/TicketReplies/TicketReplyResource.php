<?php

namespace App\Filament\Resources\TicketReplies;

use App\Filament\Resources\TicketReplies\Pages\CreateTicketReply;
use App\Filament\Resources\TicketReplies\Pages\EditTicketReply;
use App\Filament\Resources\TicketReplies\Pages\ListTicketReplies;
use App\Filament\Resources\TicketReplies\Schemas\TicketReplyForm;
use App\Filament\Resources\TicketReplies\Tables\TicketRepliesTable;
use App\Models\TicketReply;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TicketReplyResource extends Resource
{
    protected static ?string $model = TicketReply::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'message';

    public static function form(Schema $schema): Schema
    {
        return TicketReplyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TicketRepliesTable::configure($table);
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
            'index' => ListTicketReplies::route('/'),
            'create' => CreateTicketReply::route('/create'),
            'edit' => EditTicketReply::route('/{record}/edit'),
        ];
    }
}
