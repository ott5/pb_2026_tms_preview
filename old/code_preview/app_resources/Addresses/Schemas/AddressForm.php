<?php

namespace App\Filament\Clusters\System\Resources\Addresses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Filament\Schemas\AddressFields;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
class AddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AddressFields::getCountrySelect('postalCode.city.countryRegion.country', 'name')
                    ->afterStateUpdated(function (Set $set){
                        $set('country_region_id', null);
                        $set('city_id', null);
                        $set('postal_code_id', null);
                    })
                    ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                        $set('country', $record?->postalCode?->city?->countryRegion?->country_tag)
                    )
                    ->required(),
                AddressFields::getCountryRegionSelect('postalCode.city.countryRegion', 'name')
                    ->afterStateUpdated(function (Set $set){
                        $set('city_id', null);
                        $set('postal_code_id', null);
                    })
                    ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                        $set('country_region_id', $record?->postalCode?->city?->country_region_id)
                    )
                    ->required(),
                AddressFields::getCitySelect('postalCode.city', 'name')
                    ->afterStateUpdated(function (Set $set){
                        $set('postal_code_id', null);
                    })
                    ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                        $set('city_id', $record?->postalCode?->city?->id)
                    )
                    ->required(),
                AddressFields::getPostalCodeSelect('postalCode', 'code'),
                TextInput::make('street')
                    ->label('Ulica'),
                TextInput::make('building_number')
                    ->label('Numer budynku')
                    ->required(),
                TextInput::make('apartment_number')
                    ->label('Numer mieszkania'),
            ]);
    }
    public static function getFormSchema(): array
    {
        return self::configure(new Schema())->getComponents();
    }
}
