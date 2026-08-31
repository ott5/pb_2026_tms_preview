<?php

namespace App\Filament\Clusters\Registry\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label("Country Name")
                    ->placeholder("Enter country name")
                    ->required(),
                TextInput::make('code')
                    ->label("Country Code")
                    ->placeholder("Enter country code")
                    ->hintIcon('heroicon-o-information-circle')
                    ->hint('Country ISO 3166-1 alpha-2 code')
                    ->length(2)
                    ->required(),
                TextInput::make('nationality')
                    ->label("Nationality")
                    ->placeholder("Enter nationality")
                    ->required(),
            ]);
    }
}
