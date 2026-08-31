<?php

namespace App\Filament\Clusters\System\Resources\Addresses\Pages;

use App\Filament\Clusters\System\Resources\Addresses\AddressResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAddresses extends ListRecords
{
    protected static string $resource = AddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
