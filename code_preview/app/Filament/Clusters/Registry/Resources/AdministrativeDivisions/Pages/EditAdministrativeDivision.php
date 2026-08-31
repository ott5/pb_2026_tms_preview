<?php

namespace App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Pages;

use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\AdministrativeDivisionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdministrativeDivision extends EditRecord
{
    protected static string $resource = AdministrativeDivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
