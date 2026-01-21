<?php

namespace App\Filament\Resources\Printts;

use App\Filament\Resources\Printts\Pages\CreatePrintt;
use App\Filament\Resources\Printts\Pages\EditPrintt;
use App\Filament\Resources\Printts\Pages\ListPrintts;
use App\Filament\Resources\Printts\Pages\ViewPrintt;
use App\Filament\Resources\Printts\Schemas\PrinttForm;
use App\Filament\Resources\Printts\Schemas\PrinttInfolist;
use App\Filament\Resources\Printts\Tables\PrinttsTable;
use App\Models\Printt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PrinttResource extends Resource
{
    protected static ?string $model = Printt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // protected static ?string $recordTitleAttribute = 'print';
    protected static ?string $navigationLabel = 'طباعة الجرد ';

    protected static UnitEnum|string|null $navigationGroup = 'المستودع';


    public static function form(Schema $schema): Schema
    {
        return PrinttForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PrinttInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrinttsTable::configure($table);
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
            'index' => ListPrintts::route('/'),
            'create' => CreatePrintt::route('/create'),
            'view' => ViewPrintt::route('/{record}'),
            'edit' => EditPrintt::route('/{record}/edit'),
        ];
    }
}
