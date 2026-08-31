<?php

namespace App\Filament\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressFields
{    
    public static function getCountrySelect(string $relationshipName='countryRegion.country', string $titleAttribute='name',): Select{
        return Select::make('country')
            ->label('Państwo')
            ->placeholder('Wybierz państwo')
            ->getOptionLabelUsing(fn ($value) => \App\Models\Country::where('tag', $value)->first()?->name)
            ->relationship($relationshipName, $titleAttribute)            
            ->live()
            ->searchable()
            ->preload();
    }
    public static function getCountryRegionSelect(string $relationshipName='countryRegion', string $titleAttribute='name',): Select{
        return Select::make('country_region_id')
            ->label('Region Państwa')
            ->placeholder(fn (Get $get) => empty($get('country')) ? 'Najpierw wybierz państwo' : 'Wybierz region')
            ->disabled(fn($get)=>empty($get('country')))
            ->getOptionLabelUsing(fn ($value) => \App\Models\CountryRegion::find($value)?->name)
            ->relationship(
                name: $relationshipName,
                titleAttribute: $titleAttribute,
                modifyQueryUsing: fn (Builder $query, Get $get)
                    =>$query->whereHas('country', fn($q)
                        =>$q->where('tag', $get('country'))),                    
            )
            ->searchable()
            ->live()
            ->preload();
        }
    public static function getCitySelect(string $relationshipName='city',string $titleAttribute='name',): Select{
        return Select::make('city_id')
            ->label('Miejscowość')
            ->placeholder(fn (Get $get) => empty($get('country')) ? 'Najpierw wybierz region' : 'Wybierz miasto')
            ->disabled(fn($get)=>empty($get('country_region_id')))
            ->getOptionLabelUsing(fn ($value) => \App\Models\City::find($value)?->name)
            ->relationship(
                name: $relationshipName,
                titleAttribute: $titleAttribute,
                modifyQueryUsing: fn (Builder $query, Get $get)
                    =>$query->whereHas('countryRegion', fn($q)
                        =>$q->where('id', $get('country_region_id'))),
            )
            ->searchable()
            ->live()
            ->preload();
    }
    public static function getPostalCodeSelect(string $relationshipName='postalCode',string $titleAttribute='code',): Select{
        return Select::make('postal_code_id')
            ->label('Kod pocztowy')
            ->placeholder(fn (Get $get) => empty($get('city_id')) ? 'Najpierw wybierz miasto' : 'Wybierz kod pocztowy')
            ->disabled(fn($get)=>empty($get('city_id')))
            ->getOptionLabelUsing(fn ($value) => \App\Models\PostalCode::find($value)?->code)
            ->relationship(
                name: $relationshipName,
                titleAttribute: $titleAttribute,
                modifyQueryUsing: fn (Builder $query, Get $get)
                    =>$query->whereHas('city', fn($q)
                        =>$q->where('id', $get('city_id'))),
            )
            ->searchable()
            ->live()
            ->preload();
    }
    public static function getFilterFields(string $relationshipPrefix=''): array{
        $p=filled($relationshipPrefix) ? $relationshipPrefix.'.' : '';
        return [
            Filter::make('Address')
                ->schema([
                    self::getCountrySelect($p.'postalCode.city.countryRegion.country', 'name')
                        ->afterStateUpdated(function (Set $set){
                            $set('country_region_id', null);
                            $set('city_id', null);
                            $set('postal_code_id', null);
                        }),
                    self::getCountryRegionSelect($p.'postalCode.city.countryRegion', 'name')
                        ->afterStateUpdated(function (Set $set){
                            $set('city_id', null);
                            $set('postal_code_id', null);
                        }),
                     self::getCitySelect($p.'postalCode.city', 'name')
                        ->afterStateUpdated(function (Set $set){
                            $set('postal_code_id', null);
                        }),
                     self::getPostalCodeSelect($p.'postalCode', 'code'),
                ])
                ->query(function (Builder $query, array $data){
                    return $query
                        ->when($data['country'] ?? null, function (Builder $query, $country){
                            $query->whereRelation('postalCode.city.countryRegion.country', 'tag', $country);
                        })
                        ->when($data['country_region_id'] ?? null, function (Builder $query, $countryRegionId){
                            $query->whereRelation('postalCode.city', 'country_region_id', $countryRegionId);
                        })
                        ->when($data['city_id'] ?? null, function (Builder $query, $cityId){
                            $query->whereRelation('postalCode', 'city_id', $cityId);
                        })
                        ->when($data['postal_code_id'] ?? null, function (Builder $query, $postalCodeId){
                            $query->where('postal_code_id', $postalCodeId);
                        });
                })
                ->indicateUsing(function (array $data) {
                    $indicators = [];
                    if ($data['country'] ?? null) {
                        $name=\App\Models\Country::find($data['country'])?->name;
                        $indicators['country'] = "Nazwa państwa: {$name}";
                    }
                    if($data['country_region_id'] ?? null) {
                        $name=\App\Models\CountryRegion::find($data['country_region_id'])?->name;
                        $indicators['country_region_id'] = "Nazwa regionu: {$name}";
                    }
                    if($data['city_id'] ?? null) {
                        $name=\App\Models\City::find($data['city_id'])?->name;
                        $indicators['city_id'] = "Nazwa miejscowości: {$name}";
                    }
                    if($data['postal_code_id'] ?? null) {
                        $name=\App\Models\PostalCode::find($data['postal_code_id'])?->code;
                        $indicators['postal_code_id'] = "Kod pocztowy: {$name}";
                    }
                    if(empty($indicators)){
                        return null;
                    }
                    return $indicators;
                }),
        ];
    }
    public static function getFormFields(string $relationshipPrefix=''): array{
        $p=filled($relationshipPrefix) ? $relationshipPrefix.'.' : '';
        return [

            self::getCountrySelect($p.'postalCode.city.countryRegion.country', 'name')
                ->afterStateUpdated(function (Set $set){
                    $set('country_region_id', null);
                    $set('city_id', null);
                    $set('postal_code_id', null);
                })
                ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                    $set('country', $record?->postalCode?->city?->countryRegion?->country_tag)
                )
                ->required(),
            self::getCountryRegionSelect($p.'postalCode.city.countryRegion', 'name')
                ->afterStateUpdated(function (Set $set){
                    $set('city_id', null);
                    $set('postal_code_id', null);
                })
                ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                    $set('country_region_id', $record?->postalCode?->city?->country_region_id)
                )
                ->required(),
            self::getCitySelect($p.'postalCode.city', 'name')
                ->afterStateUpdated(function (Set $set){
                    $set('postal_code_id', null);
                })
                ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                    $set('city_id', $record?->postalCode?->city?->id)
                )
                ->required(),
            self::getPostalCodeSelect($p.'postalCode', 'code')
                ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                    $set('postal_code_id', $record?->postalCode?->id)
                ),
            TextInput::make('street')
                ->label('Ulica')
                ->columnSpan(2)
                ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                    $set('street', $record?->street)
                ),
            TextInput::make('building_number')
                ->label('Numer budynku')
                ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                    $set('building_number', $record?->building_number)
                )
                ->required(),
            TextInput::make('apartment_number')
                ->label('Numer mieszkania')
                ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                    $set('apartment_number', $record?->apartment_number)
                ),
        ];
    }
}
