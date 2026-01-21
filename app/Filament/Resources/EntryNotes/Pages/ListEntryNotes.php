<?php

namespace App\Filament\Resources\EntryNotes\Pages;

use App\Filament\Resources\EntryNotes\EntryNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEntryNotes extends ListRecords
{
    protected static string $resource = EntryNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
