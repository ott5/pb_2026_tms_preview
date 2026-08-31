<?php

namespace App\Filament\Clusters\Registry\Resources\Countries\Pages;

use App\Filament\Clusters\Registry\Resources\Countries\CountryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCountry extends EditRecord
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
