<?php

namespace App\Filament\Resources\EntryNotes\Pages;

use App\Filament\Resources\EntryNotes\EntryNoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEntryNote extends ViewRecord
{
    protected static string $resource = EntryNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
