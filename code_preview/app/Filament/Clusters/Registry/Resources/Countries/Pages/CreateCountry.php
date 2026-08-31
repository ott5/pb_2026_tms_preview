<?php

namespace App\Filament\Clusters\Registry\Resources\Countries\Pages;

use App\Filament\Clusters\Registry\Resources\Countries\CountryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
}
