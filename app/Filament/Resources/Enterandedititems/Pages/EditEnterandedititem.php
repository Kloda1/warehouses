<?php

namespace App\Filament\Resources\Enterandedititems\Pages;

use App\Filament\Resources\Enterandedititems\EnterandedititemResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEnterandedititem extends EditRecord
{
    protected static string $resource = EnterandedititemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
