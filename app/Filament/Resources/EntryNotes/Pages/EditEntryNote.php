<?php

namespace App\Filament\Resources\EntryNotes\Pages;

use App\Filament\Resources\EntryNotes\EntryNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEntryNote extends EditRecord
{
    protected static string $resource = EntryNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
