<?php

namespace App\Filament\Clusters\Registry\Resources\Addresses\Pages;

use App\Filament\Clusters\Registry\Resources\Addresses\AddressResource;
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
