<?php

namespace App\Filament\Clusters\Registry\Resources\Addresses\Schemas;

use Filament\Forms\Components\TextInput;
use App\Filament\Schemas\AddressSchema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;

class AddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components(static::getComponents());
    }
    public static function getComponents(): array
    {
        return [
            AddressSchema::countrySelect('cityPostalCode.city.countryRegion.country')
                ->dehydrated(false)
                ->afterStateUpdated(function ($set){
                    $set('cityPostalCode.city.country_region_id', null);
                    $set('cityPostalCode.city_id', null);
                    $set('cityPostalCode.postal_code_id', null);
                })
                ->afterStateHydrated(function ($set, $record) {
                    $set('country_id', $record?->cityPostalCode?->city?->countryRegion?->country_id);
                })
                ->required(),
            AddressSchema::countryRegionSelect('cityPostalCode.city.countryRegion')
                ->dehydrated(false)
                    ->afterStateUpdated(function ($set){
                    $set('cityPostalCode.city_id', null);
                    $set('cityPostalCode.postal_code_id', null);
                })
                ->afterStateHydrated(function ($set, $record) {
                    $set('country_region_id', $record?->cityPostalCode?->city?->country_region_id);
                })
                ->disabled(fn($get)=>empty($get('country_id')))
                ->required(),
            AddressSchema::citySelect('cityPostalCode.city')
                ->dehydrated(false)
                ->afterStateUpdated(function ($set){
                    $set('cityPostalCode.postal_code_id', null);
                })
                ->afterStateHydrated(function ($set, $record) {
                    $set('city_id', $record?->cityPostalCode?->city_id);
                })
                ->disabled(fn($get)=>empty($get('country_region_id')))
                ->required(),
            AddressSchema::postalCodeSelect('cityPostalCode')
                ->afterStateHydrated(function ($set, $record) {
                    $set('postal_code_id', $record?->cityPostalCode?->postal_code_id);
                })
                ->disabled(fn($get)=>empty($get('city_id')))
                ->required(),
            TextInput::make('street'),
            TextInput::make('building_number')
                ->required(),
            TextInput::make('apartment_number'),
        ];
    }
}
