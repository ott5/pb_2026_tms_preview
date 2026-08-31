<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Pages;

use App\Filament\Clusters\Employee\Resources\EmployeeDocuments\EmployeeDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeDocument extends CreateRecord
{
    protected static string $resource = EmployeeDocumentResource::class;
}
