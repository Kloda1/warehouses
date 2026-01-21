<?php

namespace App\Filament\Resources\Enterandedititems\Pages;

use App\Filament\Resources\Enterandedititems\EnterandedititemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEnterandedititems extends ListRecords
{
    protected static string $resource = EnterandedititemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
