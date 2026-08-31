<?php

namespace App\Filament\Clusters\Registry\Resources\PostalCodes\Pages;

use App\Filament\Clusters\Registry\Resources\PostalCodes\PostalCodeResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePostalCode extends CreateRecord
{
    protected static string $resource = PostalCodeResource::class;
}
