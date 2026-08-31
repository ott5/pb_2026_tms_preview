<?php

namespace App\Filament\Clusters\Registry\Resources\Cities\Pages;

use App\Filament\Clusters\Registry\Resources\Cities\CityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCity extends EditRecord
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
