<?php

namespace App\Filament\Clusters\Registry\Resources\CountryRegions\Pages;

use App\Filament\Clusters\Registry\Resources\CountryRegions\CountryRegionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCountryRegion extends ViewRecord
{
    protected static string $resource = CountryRegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
