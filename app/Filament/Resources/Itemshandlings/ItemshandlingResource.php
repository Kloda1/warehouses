<?php

namespace App\Filament\Resources\Itemshandlings;

use App\Filament\Resources\Itemshandlings\Pages\CreateItemshandling;
use App\Filament\Resources\Itemshandlings\Pages\EditItemshandling;
use App\Filament\Resources\Itemshandlings\Pages\ListItemshandlings;
use App\Filament\Resources\Itemshandlings\Pages\ViewItemshandling;
use App\Filament\Resources\Itemshandlings\Schemas\ItemshandlingForm;
use App\Filament\Resources\Itemshandlings\Schemas\ItemshandlingInfolist;
use App\Filament\Resources\Itemshandlings\Tables\ItemshandlingsTable;
use App\Models\Itemshandling;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ItemshandlingResource extends Resource
{
    protected static ?string $model = Itemshandling::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = ' حركة مواد المستودعات';

    protected static UnitEnum|string|null $navigationGroup = 'المستودع';


    // protected static ?string $recordTitleAttribute = 'item';

    public static function form(Schema $schema): Schema
    {
        return ItemshandlingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ItemshandlingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItemshandlingsTable::configure($table);
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
            'index' => ListItemshandlings::route('/'),
            'create' => CreateItemshandling::route('/create'),
            'view' => ViewItemshandling::route('/{record}'),
            'edit' => EditItemshandling::route('/{record}/edit'),
        ];
    }
}
