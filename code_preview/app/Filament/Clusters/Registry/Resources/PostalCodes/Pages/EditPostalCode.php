<?php

namespace App\Filament\Clusters\Registry\Resources\PostalCodes\Pages;

use App\Filament\Clusters\Registry\Resources\PostalCodes\PostalCodeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPostalCode extends EditRecord
{
    protected static string $resource = PostalCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
