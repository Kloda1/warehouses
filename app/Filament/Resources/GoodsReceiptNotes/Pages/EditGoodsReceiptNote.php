<?php

namespace App\Filament\Resources\GoodsReceiptNotes\Pages;

use App\Filament\Resources\GoodsReceiptNotes\GoodsReceiptNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGoodsReceiptNote extends EditRecord
{
    protected static string $resource = GoodsReceiptNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
