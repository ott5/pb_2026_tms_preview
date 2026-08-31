<?php

namespace App\Filament\Clusters\Registry\Resources\Addresses\Pages;

use App\Filament\Clusters\Registry\Resources\Addresses\AddressResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAddress extends ViewRecord
{
    protected static string $resource = AddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
