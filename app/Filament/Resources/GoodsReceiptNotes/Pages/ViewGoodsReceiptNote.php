<?php

namespace App\Filament\Resources\GoodsReceiptNotes\Pages;

use App\Filament\Resources\GoodsReceiptNotes\GoodsReceiptNoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGoodsReceiptNote extends ViewRecord
{
    protected static string $resource = GoodsReceiptNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
