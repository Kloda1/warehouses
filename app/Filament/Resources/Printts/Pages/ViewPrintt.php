<?php

namespace App\Filament\Resources\Printts\Pages;

use App\Filament\Resources\Printts\PrinttResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPrintt extends ViewRecord
{
    protected static string $resource = PrinttResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
