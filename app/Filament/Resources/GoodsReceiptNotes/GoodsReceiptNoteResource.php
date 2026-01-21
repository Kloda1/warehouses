<?php

namespace App\Filament\Resources\GoodsReceiptNotes;

use App\Filament\Resources\GoodsReceiptNotes\Pages\CreateGoodsReceiptNote;
use App\Filament\Resources\GoodsReceiptNotes\Pages\EditGoodsReceiptNote;
use App\Filament\Resources\GoodsReceiptNotes\Pages\ListGoodsReceiptNotes;
use App\Filament\Resources\GoodsReceiptNotes\Pages\ViewGoodsReceiptNote;
use App\Filament\Resources\GoodsReceiptNotes\Schemas\GoodsReceiptNoteForm;
use App\Filament\Resources\GoodsReceiptNotes\Schemas\GoodsReceiptNoteInfolist;
use App\Filament\Resources\GoodsReceiptNotes\Tables\GoodsReceiptNotesTable;
use App\Models\GoodsReceiptNote;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;


class GoodsReceiptNoteResource extends Resource
{
    protected static ?string $model = GoodsReceiptNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentChartBar;

    // protected static ?string $recordTitleAttribute = 'note';
    protected static UnitEnum|string|null $navigationGroup = 'المذكرات';
    protected static ?string $navigationLabel = 'مذكرة استلام';


    public static function form(Schema $schema): Schema
    {
        return GoodsReceiptNoteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GoodsReceiptNoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GoodsReceiptNotesTable::configure($table);
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
            'index' => ListGoodsReceiptNotes::route('/'),
            'create' => CreateGoodsReceiptNote::route('/create'),
            'view' => ViewGoodsReceiptNote::route('/{record}'),
            'edit' => EditGoodsReceiptNote::route('/{record}/edit'),
        ];
    }
}
