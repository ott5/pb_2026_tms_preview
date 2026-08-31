<?php

namespace App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Filament\Schemas\AddressSchema;
use App\Enums\DivisionType;
use Filament\Schemas\Schema;

class AdministrativeDivisionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AddressSchema::countrySelect('countryRegion.country')
                    ->afterStateUpdated(function ($set){
                        $set('name', null);
                        $set('country_region_id', null);
                        $set('parent_id', null);
                    })
                    ->afterStateHydrated(function ($set, $record) {
                        $set('country_id', $record?->countryRegion?->country_id);
                        $set('country_region_id', $record?->country_region_id);
                        $set('parent_id', $record?->parent_id);
                    })
                    ->required(),
                AddressSchema::countryRegionSelect('countryRegion')
                    ->afterStateUpdated(function ($set){
                        $set('name', null);
                        $set('parent_id', null);
                    })
                    ->disabled(fn($get)=>empty($get('country_id')))                    
                    ->required(),
                Select::make('parent_id')
                    ->label('Parent Division')
                    ->live()
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'name',
                        modifyQueryUsing: function ($query, callable $get, $record) {
            $regionId = $get('country_region_id');

            return $query
                ->when($regionId, fn ($q) => $q->where('country_region_id', $regionId))
                ->when($record?->exists, fn ($q) => $q->where('id', '!=', $record->id));
        }
                    )
                    ->disabled(fn($get)=>empty($get('country_region_id')))
                    ->placeholder(fn($get)=>empty($get('country_region_id')) ? 'Select a region first' : 'Choose a parent division (optional)'),
                Select::make('type')
                    ->label('Division Type')
                    ->placeholder('Choose a division type')
                    ->live()
                    ->options(fn ($get) => DivisionType::getLabelOptionsForCountry(
                        \App\Models\CountryRegion::find($get('country_region_id'))?->country?->code
                    ))
                    ->disabled(fn($get)=>empty($get('country_region_id')))
                    ->placeholder(fn($get)=>empty($get('country_region_id')) ? 'Select a region first' : 'Choose a division type')
                    ->searchable()
                    ->required(),
                TextInput::make('name')
                    ->label('Division Name')
                    ->live()
                    ->disabled(fn($get)=>empty($get('type')) || empty($get('country_region_id')))
                    ->placeholder(fn($get)=>empty($get('type')) ? 'Select a region first' : 'Enter division name')
                    ->required(),
                TextInput::make('code')
                    ->label('Division Code')
                    ->live()                    
                    ->hintIcon('heroicon-o-information-circle')
                    ->hint('Nullable. If the division has no code, leave this field empty.')
                    ->disabled(fn($get)=>empty($get('type')) || empty($get('country_region_id')))
                    ->placeholder(fn($get)=>empty($get('type')) ? 'Select a region first' : 'Enter division code')
            ]);
    }
}
