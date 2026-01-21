<?php

namespace App\Filament\Resources\Itemshandlings\Pages;

use App\Filament\Resources\Itemshandlings\ItemshandlingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewItemshandling extends ViewRecord
{
    protected static string $resource = ItemshandlingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
