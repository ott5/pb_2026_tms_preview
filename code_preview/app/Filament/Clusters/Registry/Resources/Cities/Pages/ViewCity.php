<?php

namespace App\Filament\Clusters\Registry\Resources\Cities\Pages;

use App\Filament\Clusters\Registry\Resources\Cities\CityResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCity extends ViewRecord
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
