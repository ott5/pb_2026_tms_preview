<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Pages;

use App\Filament\Clusters\Employee\Resources\EmployeeDocuments\EmployeeDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeDocument extends EditRecord
{
    protected static string $resource = EmployeeDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
