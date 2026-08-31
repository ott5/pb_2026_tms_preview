<?php

namespace App\Filament\Clusters\Registry\Resources\Cities\Pages;

use App\Filament\Clusters\Registry\Resources\Cities\CityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCities extends ListRecords
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
