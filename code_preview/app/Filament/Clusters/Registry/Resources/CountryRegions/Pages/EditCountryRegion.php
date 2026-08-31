<?php

namespace App\Filament\Clusters\Registry\Resources\CountryRegions\Pages;

use App\Filament\Clusters\Registry\Resources\CountryRegions\CountryRegionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCountryRegion extends EditRecord
{
    protected static string $resource = CountryRegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
