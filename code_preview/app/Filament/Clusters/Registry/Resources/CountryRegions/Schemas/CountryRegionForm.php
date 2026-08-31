<?php

namespace App\Filament\Clusters\Registry\Resources\CountryRegions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Filament\Schemas\AddressSchema;
use Filament\Schemas\Schema;

class CountryRegionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AddressSchema::countrySelect('country')
                    ->afterStateHydrated(function ($set, $record) {
                        $set('country_id', $record?->country_id);
                    })
                    ->required(),
                TextInput::make('name')
                    ->label('Region Name')
                    ->disabled(fn($get)=>empty($get('country_id')))
                    ->placeholder(fn($get)=>empty($get('country_id')) ? 'Select a country first' : 'Enter region name')
                    ->required(),
                TextInput::make('code')
                    ->label('Region Code')
                    ->hintIcon('heroicon-o-information-circle')
                    ->hint('ISO 3166-2 region code (without country prefix)')
                    ->minLength(2)
                    ->maxLength(3)
                    ->disabled(fn($get)=>empty($get('country_id')))
                    ->placeholder(fn($get)=>empty($get('country_id')) ? 'Select a country first' : 'Enter region code')
                    ->required(),
            ]);
    }
}
