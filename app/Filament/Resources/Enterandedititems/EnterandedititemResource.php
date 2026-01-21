<?php

namespace App\Filament\Resources\Enterandedititems;

use App\Filament\Resources\Enterandedititems\Pages\CreateEnterandedititem;
use App\Filament\Resources\Enterandedititems\Pages\EditEnterandedititem;
use App\Filament\Resources\Enterandedititems\Pages\ListEnterandedititems;
use App\Filament\Resources\Enterandedititems\Pages\ViewEnterandedititem;
use App\Filament\Resources\Enterandedititems\Schemas\EnterandedititemForm;
use App\Filament\Resources\Enterandedititems\Schemas\EnterandedititemInfolist;
use App\Filament\Resources\Enterandedititems\Tables\EnterandedititemsTable;
use App\Models\Enterandedititem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EnterandedititemResource extends Resource
{
    protected static ?string $model = Enterandedititem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // protected static ?string $recordTitleAttribute = 'item';
    protected static ?string $navigationLabel = ' ادخال وتعديل بطاقة المادة';

    protected static UnitEnum|string|null $navigationGroup = 'المستودع';


    public static function form(Schema $schema): Schema
    {
        return EnterandedititemForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EnterandedititemInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EnterandedititemsTable::configure($table);
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
            'index' => ListEnterandedititems::route('/'),
            'create' => CreateEnterandedititem::route('/create'),
            'view' => ViewEnterandedititem::route('/{record}'),
            'edit' => EditEnterandedititem::route('/{record}/edit'),
        ];
    }
}
