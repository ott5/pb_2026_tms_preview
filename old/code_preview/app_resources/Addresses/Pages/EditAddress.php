<?php

namespace App\Filament\Clusters\System\Resources\Addresses\Pages;

use App\Filament\Clusters\System\Resources\Addresses\AddressResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAddress extends EditRecord
{
    protected static string $resource = AddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
