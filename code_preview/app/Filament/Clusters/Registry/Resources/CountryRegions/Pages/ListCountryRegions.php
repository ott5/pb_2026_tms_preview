<?php

namespace App\Filament\Clusters\Registry\Resources\CountryRegions\Pages;

use App\Filament\Clusters\Registry\Resources\CountryRegions\CountryRegionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCountryRegions extends ListRecords
{
    protected static string $resource = CountryRegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
