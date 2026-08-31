<?php

namespace App\Filament\Clusters\Registry\Resources\PostalCodes\Pages;

use App\Filament\Clusters\Registry\Resources\PostalCodes\PostalCodeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPostalCodes extends ListRecords
{
    protected static string $resource = PostalCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
