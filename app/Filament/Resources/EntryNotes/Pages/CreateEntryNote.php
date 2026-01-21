<?php

namespace App\Filament\Resources\EntryNotes\Pages;

use App\Filament\Resources\EntryNotes\EntryNoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEntryNote extends CreateRecord
{
    protected static string $resource = EntryNoteResource::class;
}
