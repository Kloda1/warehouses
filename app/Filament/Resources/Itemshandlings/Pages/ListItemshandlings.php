<?php

namespace App\Filament\Resources\Itemshandlings\Pages;

use App\Filament\Resources\Itemshandlings\ItemshandlingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListItemshandlings extends ListRecords
{
    protected static string $resource = ItemshandlingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
