<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Pages;

use App\Filament\Clusters\Employee\Resources\EmployeeDocuments\EmployeeDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeDocuments extends ListRecords
{
    protected static string $resource = EmployeeDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
