<?php

namespace App\Filament\Resources\Installations\Pages;

use App\Filament\Resources\Installations\InstallationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInstallation extends ViewRecord
{
    protected static string $resource = InstallationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
