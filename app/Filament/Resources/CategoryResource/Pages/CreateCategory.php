<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

   protected function mutateFormDataBeforeCreate(array $data): array
    {
   
        if (empty($data['code'])) {
            $data['code'] = 'CAT_' . time();
        }
        
        return $data;
    }
}
