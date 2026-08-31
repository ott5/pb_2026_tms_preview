<?php

namespace App\Filament\Clusters\Registry\Resources\Cities\Pages;

use App\Filament\Clusters\Registry\Resources\Cities\CityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;
}
