<?php

namespace App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Pages;

use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\AdministrativeDivisionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAdministrativeDivision extends ViewRecord
{
    protected static string $resource = AdministrativeDivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
