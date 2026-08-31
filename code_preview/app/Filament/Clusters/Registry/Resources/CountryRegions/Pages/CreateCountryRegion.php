<?php

namespace App\Filament\Clusters\Registry\Resources\CountryRegions\Pages;

use App\Filament\Clusters\Registry\Resources\CountryRegions\CountryRegionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCountryRegion extends CreateRecord
{
    protected static string $resource = CountryRegionResource::class;
}
