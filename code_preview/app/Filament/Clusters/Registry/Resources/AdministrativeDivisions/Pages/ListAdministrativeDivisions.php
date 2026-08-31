<?php

namespace App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Pages;

use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\AdministrativeDivisionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdministrativeDivisions extends ListRecords
{
    protected static string $resource = AdministrativeDivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
