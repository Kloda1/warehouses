<?php

namespace App\Filament\Resources\Installations;

use App\Filament\Resources\Installations\Pages\CreateInstallation;
use App\Filament\Resources\Installations\Pages\EditInstallation;
use App\Filament\Resources\Installations\Pages\ListInstallations;
use App\Filament\Resources\Installations\Pages\ViewInstallation;
use App\Filament\Resources\Installations\Schemas\InstallationForm;
use App\Filament\Resources\Installations\Schemas\InstallationInfolist;
use App\Filament\Resources\Installations\Tables\InstallationsTable;
use App\Models\Installation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InstallationResource extends Resource
{
    protected static ?string $model = Installation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentChartBar;

    // protected static ?string $recordTitleAttribute = 'note';
    protected static ?string $navigationLabel = 'محضر تركيب وتنسيق ';

    protected static UnitEnum|string|null $navigationGroup = 'المذكرات';


    public static function form(Schema $schema): Schema
    {
        return InstallationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstallationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstallationsTable::configure($table);
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
            'index' => ListInstallations::route('/'),
            'create' => CreateInstallation::route('/create'),
            'view' => ViewInstallation::route('/{record}'),
            'edit' => EditInstallation::route('/{record}/edit'),
        ];
    }
}
