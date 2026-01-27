<?php

namespace App\Filament\Resources\BillResource\Pages;

use App\Filament\Resources\BillResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ItemResource;

class CreateBill extends CreateRecord
{
    protected static string $resource = BillResource::class;
        protected function getRedirectUrl(): string
    {
        return ItemResource::getUrl('create', [
            'bill_number' => $this->record->bill_number,
        ]);
    }
}
