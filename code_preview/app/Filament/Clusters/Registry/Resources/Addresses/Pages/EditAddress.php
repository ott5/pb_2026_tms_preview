<?php

namespace App\Filament\Clusters\Registry\Resources\Addresses\Pages;

use App\Filament\Clusters\Registry\Resources\Addresses\AddressResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAddress extends EditRecord
{
    protected static string $resource = AddressResource::class;
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
