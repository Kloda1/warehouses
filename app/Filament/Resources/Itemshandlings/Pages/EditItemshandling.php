<?php

namespace App\Filament\Resources\Itemshandlings\Pages;

use App\Filament\Resources\Itemshandlings\ItemshandlingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditItemshandling extends EditRecord
{
    protected static string $resource = ItemshandlingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
