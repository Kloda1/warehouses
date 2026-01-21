<?php

namespace App\Filament\Resources\Printts\Pages;

use App\Filament\Resources\Printts\PrinttResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPrintts extends ListRecords
{
    protected static string $resource = PrinttResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
