<?php

namespace App\Filament\Resources\Printts\Pages;

use App\Filament\Resources\Printts\PrinttResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPrintt extends EditRecord
{
    protected static string $resource = PrinttResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
