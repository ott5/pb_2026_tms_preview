<?php

namespace App\Filament\Clusters\Registry\Resources\Cities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Filament\Schemas\AddressSchema;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AddressSchema::countrySelect('countryRegion.country')
                    ->afterStateUpdated(function ($set){
                        $set('name', null);
                        $set('country_region_id', null);
                        $set('postalCodes', []);
                        $set('administrativeDivisions', []);
                    })
                    ->afterStateHydrated(function ($set, $record) {
                        $set('country_id', $record?->countryRegion?->country_id);
                    })
                    ->required(),
                AddressSchema::countryRegionSelect('countryRegion')
                    ->afterStateUpdated(function ($set){
                        $set('name', null);
                        $set('postalCodes', []);
                        $set('administrativeDivisions', []);
                    })
                    ->disabled(fn($get)=>empty($get('country_id')))                    
                    ->required(),
                TextInput::make('name')
                    ->label('City Name')
                    ->disabled(fn($get)=>empty($get('country_region_id')))
                    ->placeholder(fn($get)=>empty($get('country_region_id')) ? 'Select a region first' : 'Enter city name')
                    ->required(),
                Select::make('postalCodes')
                    ->label('Postal Codes')
                    ->multiple()
                    ->relationship(
                        name: 'postalCodes',
                        titleAttribute: 'code',
                        modifyQueryUsing: function ($query, $get) {
                            $regionId = $get('country_region_id');
                            $countryId = \App\Models\CountryRegion::find($regionId)?->country_id;
                            return $query->when($countryId, fn ($q) => $q->where('country_id', $countryId), fn ($q) => $q->whereRaw('1 = 0'));
                        }
                    )
                    ->disabled(fn($get) => empty($get('country_region_id')))
                    ->preload()
                    ->searchable(),

                Select::make('administrativeDivisions')
                    ->label('Administrative Divisions')
                    ->multiple()
                    ->relationship(
                        name: 'administrativeDivisions',
                        titleAttribute: 'name',
                        modifyQueryUsing: function ($query, $get) {
                            $regionId = $get('country_region_id');
                            return $query->when($regionId, fn ($q) => $q->where('country_region_id', $regionId), fn ($q) => $q->whereRaw('1 = 0'));
                        }
                    )
                    ->disabled(fn($get) => empty($get('country_region_id')))
                    ->preload()
                    ->searchable(),
            ]);
    }
}
