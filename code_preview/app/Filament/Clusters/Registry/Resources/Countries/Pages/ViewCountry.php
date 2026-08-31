<?php

namespace App\Filament\Clusters\Registry\Resources\Countries\Pages;

use App\Filament\Clusters\Registry\Resources\Countries\CountryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCountry extends ViewRecord
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
