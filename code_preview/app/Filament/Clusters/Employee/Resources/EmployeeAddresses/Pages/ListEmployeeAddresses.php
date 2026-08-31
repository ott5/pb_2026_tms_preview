<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Pages;

use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\EmployeeAddressResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeAddresses extends ListRecords
{
    protected static string $resource = EmployeeAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
