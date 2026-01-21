<?php

namespace App\Filament\Resources\DeliveryNotes;

use App\Filament\Resources\DeliveryNotes\Pages\CreateDeliveryNote;
use App\Filament\Resources\DeliveryNotes\Pages\EditDeliveryNote;
use App\Filament\Resources\DeliveryNotes\Pages\ListDeliveryNotes;
use App\Filament\Resources\DeliveryNotes\Pages\ViewDeliveryNote;
use App\Filament\Resources\DeliveryNotes\Schemas\DeliveryNoteForm;
use App\Filament\Resources\DeliveryNotes\Schemas\DeliveryNoteInfolist;
use App\Filament\Resources\DeliveryNotes\Tables\DeliveryNotesTable;
use App\Models\DeliveryNote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
class DeliveryNoteResource extends Resource
{
    protected static ?string $model = DeliveryNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentChartBar;

    // protected static ?string $recordTitleAttribute = 'note';
    protected static ?string $navigationLabel = 'مذكرة تسليم';
    protected static UnitEnum|string|null $navigationGroup = 'المذكرات';


    public static function form(Schema $schema): Schema
    {
        return DeliveryNoteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DeliveryNoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeliveryNotesTable::configure($table);
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
            'index' => ListDeliveryNotes::route('/'),
            'create' => CreateDeliveryNote::route('/create'),
            'view' => ViewDeliveryNote::route('/{record}'),
            'edit' => EditDeliveryNote::route('/{record}/edit'),
        ];
    }
}
