<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Pages;

use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\EmployeeAddressResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeAddress extends ViewRecord
{
    protected static string $resource = EmployeeAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array{
        return array_merge($data, EditEmployeeAddress::getFormData($this->record));
    }
}