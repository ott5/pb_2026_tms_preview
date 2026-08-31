<?php

namespace App\Filament\Clusters\Registry\Resources\PostalCodes\Pages;

use App\Filament\Clusters\Registry\Resources\PostalCodes\PostalCodeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPostalCode extends ViewRecord
{
    protected static string $resource = PostalCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
