<?php

namespace App\Filament\Resources\Enterandedititems\Pages;

use App\Filament\Resources\Enterandedititems\EnterandedititemResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEnterandedititem extends ViewRecord
{
    protected static string $resource = EnterandedititemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
