<?php

namespace App\Filament\Resources\EntryNotes;

use App\Filament\Resources\EntryNotes\Pages\CreateEntryNote;
use App\Filament\Resources\EntryNotes\Pages\EditEntryNote;
use App\Filament\Resources\EntryNotes\Pages\ListEntryNotes;
use App\Filament\Resources\EntryNotes\Pages\ViewEntryNote;
use App\Filament\Resources\EntryNotes\Schemas\EntryNoteForm;
use App\Filament\Resources\EntryNotes\Schemas\EntryNoteInfolist;
use App\Filament\Resources\EntryNotes\Tables\EntryNotesTable;
use App\Models\EntryNote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EntryNoteResource extends Resource
{
    protected static ?string $model = EntryNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentChartBar;

    // protected static ?string $recordTitleAttribute = 'note';
    protected static ?string $navigationLabel = 'مذكرة ادخال';

    protected static UnitEnum|string|null $navigationGroup = 'المذكرات';


    public static function form(Schema $schema): Schema
    {
        return EntryNoteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EntryNoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EntryNotesTable::configure($table);
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
            'index' => ListEntryNotes::route('/'),
            'create' => CreateEntryNote::route('/create'),
            'view' => ViewEntryNote::route('/{record}'),
            'edit' => EditEntryNote::route('/{record}/edit'),
        ];
    }
}
