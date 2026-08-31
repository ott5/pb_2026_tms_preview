<?php

namespace App\Filament\Schemas;

use Illuminate\Support\Arr;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use App\Models\Country;
use App\Models\CountryRegion;
use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;

class AddressSchema
{
    public static function configure(Schema $schema): Schema{
        return $schema
            ->components([
            ]);
    }
    /**
     * Select component for choosing a country in a form or filter.
     *
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Select The select component for the country field.
     */
    public static function countrySelect(string $relationshipName):Select{
        return Select::make('country_id')
            ->label('Country')
            ->relationship($relationshipName, 'name')
            ->live()
            ->preload()
            ->searchable()
            ->afterStateUpdated(function ($set){
                $set('country_region_id', null);
                $set('city_id', null);
                $set('postal_code_id', null);
            });
    }
    /**
     * Select component for choosing a country region in a form or filter.
     *
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Select The select component for the country region field.
     */
    public static function countryRegionSelect(string $relationshipName):Select{
        return Select::make('country_region_id')
            ->label('Region')
            ->relationship(
                name: $relationshipName,
                titleAttribute: 'name',
                modifyQueryUsing: function ($query, $get){
                    $countryId = $get('country_id');
                    if ($countryId) {
                        $query->whereIn('country_id', Arr::wrap($countryId));
                    }
                    return $query->orderBy('name','asc');
                }
            )
            ->live()
            ->preload()
            ->searchable()
            ->placeholder(fn($get)=>empty($get('country_id')) ? 'Select a country first' : 'Select a region')
            ->afterStateUpdated(function ($set){                
                $set('city_id', null);
                $set('postal_code_id', null);
            });
    }
    /**
     * Select component for choosing a city in a form or filter.
     *
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Select The select component for the city field.
     */
    public static function citySelect(string $relationshipName):Select{
        return Select::make('city_id')
            ->label('City')
            ->relationship(
                name: $relationshipName,
                titleAttribute: 'name',
                modifyQueryUsing: function ($query, $get){
                    $countryRegionId = $get('country_region_id');
                    if ($countryRegionId) {
                        $query->whereIn('country_region_id', Arr::wrap($countryRegionId
                        ));
                    }
                    return $query->orderBy('name','asc');
                }
            )
            ->getOptionLabelFromRecordUsing(function (\App\Models\City $record): string {
                $divisions = $record->administrativeDivisions
                    ->sortBy(fn ($item) => $item->parent_id ? 1 : 0)
                    ->pluck('name')
                    ->implode(', ');
                    return $record->name . ($divisions ? " ({$divisions}" : '') . ')';
            })
            ->live()
            ->preload()
            ->searchable()
            ->placeholder(fn($get)=>empty($get('country_region_id')) ? 'Select a region first' : 'Select a city')
            ->afterStateUpdated(function ($set){
                $set('postal_code_id', null);
            });
            
    }
    /**
     * Select component for choosing a postal code in a form or filter.
     *
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Select The select component for the postal code field.
     */
    public static function postalCodeSelect(string $relationshipName):Select{
        return Select::make('city_postal_code_id')
            ->label('Postal Code')
            ->relationship(
                name: $relationshipName,
                titleAttribute: 'id',
                modifyQueryUsing: function ($query, $get){
                    $cityId = $get('city_id');
                    if ($cityId) {
                        $query->whereIn('city_id', Arr::wrap($cityId));
                    }
                    return $query->orderBy('id','asc');
                }
            )
            ->getOptionLabelFromRecordUsing(fn ($record) => $record->postalCode?->code)
            ->live()
            ->preload()
            ->searchable()
            ->placeholder(fn($get)=>empty($get('city_id')) ? 'Select a city first' : 'Select a postal code');
    }
    /**
     * Check if the selected child IDs are valid based on the selected parent IDs and update the child field accordingly.
     * @param string $childField The name of the child field to validate.
     * @param string $modelClass The Eloquent model class of the child field.
     * @param string $foreignKey The foreign key linked to the parent model.
     * @param callable $set Filament set state callback.
     * @param callable $get Filament get state callback.
     * @param mixed $state The current state of the parent field.
     * @return void
     */
    protected static function handleParentStateUpdated(string $childField, string $modelClass,string $foreignKey, callable $set, callable $get, $state):void{
        if(empty($state)){
            $set($childField, null);
            return;
        }
        $childIds = $get($childField);
        if(!empty($childIds)){
            $valid = $modelClass::whereIn('id', Arr::wrap($childIds))
                ->whereIn($foreignKey, Arr::wrap($state))
                ->pluck('id')
                ->toArray();
            $set($childField, $valid ?: null);
        }
    }
    /**
     * Get grouped options for a select field based on the parent-child relationship in filter components. This method is used to group the options of a select field based on the parent model's name.
     * 
     * @param string $modelClass The Eloquent model class of the parent model.
     * @param string $relationName The relationship name of the child model.
     * @param string $foreignKey The foreign key linked to the parent model.
     * @param callable $get Filament get state callback.
     * @return array The grouped options for the select field.
     */
    protected static function getGroupedOptions(string $modelClass, string $relationName, string $foreignKey, callable $get): array{
        $parentId = $get($foreignKey);
        $query = $modelClass::with([$relationName => fn ($q) => $q->orderBy('name', 'asc')]);
        if (!empty($parentId)) {
            $query->whereIn('id', Arr::wrap($parentId));
        }
        $parents = $query->orderBy('name', 'asc')->get();
        $groupedOptions = [];
        foreach ($parents as $parent) {
            $groupedOptions[$parent->name] = $parent->{$relationName}->pluck('name', 'id')->toArray();
        }
        return $groupedOptions;
    }
    /**
     * Add country indicator to the filter indicators based on the selected country IDs.
     * This method is used to display the selected countries in the filter indicators.
     * 
     * @param array $data The filter data containing the selected country IDs.
     * @param array $indicators The filter indicators to be updated with the selected countries.
     * @return array The updated filter indicators with the selected countries.
     */
    protected static function addCountryIndicator(array $data, array &$indicators): array{
        if (!empty($data['country_id'])) {
            $countryNames = Country::whereIn('id', Arr::wrap($data['country_id']))->pluck('name')->implode(', ');
            $indicators[] = Indicator::make('Selected countries: ' . $countryNames)
                ->removable(false);
        }
        return $indicators;
    }
    protected static function addCountryRegionIndicator(array $data, array &$indicators): array{
        if (!empty($data['country_region_id'])) {
            $regions = CountryRegion::with('country')
                ->whereIn('id', Arr::wrap($data['country_region_id']))
                ->get();

            foreach ($regions as $region) {
                $indicators[] = Indicator::make("{$region->country->name} > {$region->name}")
                    ->removable(false);
            }
        }
        return $indicators;
    }
    /**
     * Add city indicator to the filter indicators based on the selected city IDs.
     * This method is used to display the selected cities in the filter indicators.
     *
     * @param array $data The filter data containing the selected city IDs.
     * @param array $indicators The filter indicators to be updated with the selected cities.
     * @return array The updated filter indicators with the selected cities.
     */
    protected static function addCityIndicator(array $data, array &$indicators): array{
        if (!empty($data['city_id'])) {
            $cities=City::with('countryRegion.country')
                ->whereIn('id', Arr::wrap($data['city_id']))
                ->get();
            foreach ($cities as $city) {
                $indicators[] = Indicator::make("{$city->countryRegion->country->name} > {$city->countryRegion->name} > {$city->name}")
                    ->removable(false);
            }
        }
        return $indicators;
    }
    /**
     * Add postal code indicator to the filter indicators based on the selected postal code IDs.
     * This method is used to display the selected postal codes in the filter indicators.
     *
     * @param array $data The filter data containing the selected postal code IDs.
     * @param array $indicators The filter indicators to be updated with the selected postal codes.
     * @return array The updated filter indicators with the selected postal codes.
     */
    protected static function addPostalCodeIndicator(array $data, array &$indicators): array{
        if (!empty($data['city_postal_code_id'])) {
            $postalCodes = \App\Models\CityPostalCode::with('city.countryRegion.country')
                ->whereIn('id', Arr::wrap($data['city_postal_code_id']))
                ->get();
            foreach ($postalCodes as $postalCode) {
                $indicators[] = Indicator::make("{$postalCode->city->countryRegion->country->name} > {$postalCode->city->countryRegion->name} > {$postalCode->city->name} > {$postalCode->postalCode?->code}")
                    ->removable(false);
            }
        }
        return $indicators;
    }
    /**
     * Method to create a country filter field for use in FIlament tables.
     * 
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Select The select component for the country filter field.
     */
    protected static function countryFilterField($relationshipName):Select{
        return self::countrySelect($relationshipName)
            ->multiple()
            ->afterStateUpdated(null);
    }
    /**
     * Method to create a country region filter field for use in FIlament tables.
     * 
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Select The select component for the country region filter field.
     */
    protected static function countryRegionFilterField($relationshipName):Select{
        return self::countryRegionSelect($relationshipName)
            ->multiple()
            ->disabled(fn($get)=>empty($get('country_id')))
            ->afterStateUpdated(null)
            ->options(fn ($get)=>self::getGroupedOptions(Country::class, 'countryRegions', 'country_id', $get));
    }
    /**
     * Method to create a city filter field for use in FIlament tables.
     * 
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Select The select component for the city filter field.
     */
    protected static function cityFilterField($relationshipName):Select{
        return self::citySelect($relationshipName)
            ->multiple()
            ->disabled(fn($get)=>empty($get('country_region_id')))
            ->afterStateUpdated(null)
            ->options(function ($get) {
                $regionId = $get('country_region_id');
                if (empty($regionId))
                    return [];
                return City::with('administrativeDivisions')
                    ->whereIn('country_region_id', Arr::wrap($regionId))
                    ->orderBy('name', 'asc')
                    ->get()
                    ->mapWithKeys(function ($city) {
                        $divisions = $city->administrativeDivisions
                            ->sortBy(fn ($item) => $item->parent_id ? 1 : 0)
                            ->pluck('name')
                            ->implode(', ');
                        $label = $city->name . ($divisions ? " ({$divisions})" : '');
                        return [$city->id => $label];
                    })
                    ->toArray();
            });
    }
    /**
     * Method to create a postal code filter field for use in FIlament tables.
     * 
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Select The select component for the postal code filter field.
     */
    protected static function postalCodeFilterField($relationshipName):Select{
        return self::postalCodeSelect($relationshipName)
            ->multiple()
            ->disabled(fn($get)=>empty($get('city_id')))
            ->afterStateUpdated(null)
            ->options(function($get){
                $cityId = $get('city_id');
                if (empty($cityId)) {
                    return [];
                }
                return \App\Models\CityPostalCode::whereIn('city_id', Arr::wrap($cityId))
                    ->with('postalCode')
                    ->get()
                    ->unique(fn($item) => $item?->postal_code_id)
                    ->pluck('postalCode.code', 'id')
                    ->toArray();
            });
    }
    /**
     * Method to set a location filter for a Filament table query based on the selected parent-child relationship.
     * 
     * @param Builder $query The Filament table query builder.
     * @param string $relationPath The relationship path for the parent-child relationship.
     * @param string $foreignKey The foreign key linked to the parent model.
     * @param mixed $state The current state of the parent field.
     * @return Builder The updated Filament table query builder with the location filter applied.
     */
    protected static function setLocationFilter(Builder $query, string $relationPath, string $foreignKey, $state): Builder{
        return 
            $query->when( 
                $state, fn (Builder $q, $val) => $q->whereHas($relationPath, fn (Builder $subQ) => $subQ->whereIn($foreignKey, Arr::wrap($val)))
        );
    }
    /**
     * Method to create a city filter for use in FIlament tables.
     * 
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Filter The filter component for the city filter.
     */
    public static function cityFilter(string $relationshipName): Filter{
        return Filter::make('City')
            ->schema([
                self::countryFilterField($relationshipName.'.country')
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        self::handleParentStateUpdated('country_region_id', CountryRegion::class, 'country_id', $set, $get, $state);
                    }),
                self::countryRegionFilterField($relationshipName),
            ])
            ->query(function (Builder $query, array $data) use($relationshipName): Builder {
                return $query
                    ->tap(fn($query) => self::setLocationFilter($query, $relationshipName.'.country', 'country_id', $data['country_id'] ?? null))
                    ->tap(fn($query) => self::setLocationFilter($query, $relationshipName, 'country_region_id', $data['country_region_id'] ?? null));
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];
                self::addCountryIndicator($data, $indicators);
                self::addCountryRegionIndicator($data, $indicators);
                return $indicators;
            });
    }
    /**
     * Method to create a postal code filter for use in FIlament tables.
     *
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Filter The filter component for the postal code filter.
     */
    public static function postalCodeFilter(string $relationshipName): Filter{
        return Filter::make('Postal Code')
            ->schema([
                self::countryFilterField($relationshipName.'.countryRegion.country')
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        self::handleParentStateUpdated('country_region_id', CountryRegion::class, 'country_id', $set, $get, $state);
                    }),
                self::countryRegionFilterField($relationshipName.'.countryRegion')
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        self::handleParentStateUpdated('city_id', \App\Models\City::class, 'country_region_id', $set, $get, $state);
                    }),
                self::cityFilterField($relationshipName)
            ])
            ->query(function (Builder $query, array $data) use($relationshipName): Builder {
                return $query
                    ->tap(fn($query) => self::setLocationFilter($query, $relationshipName. '.countryRegion.country','country_id', $data['country_id'] ?? null))
                    ->tap(fn($query) => self::setLocationFilter($query, $relationshipName.'.countryRegion', 'country_region_id', $data['country_region_id'] ?? null))
                    ->tap(fn($query) => self::setLocationFilter($query, $relationshipName, 'city_id', $data['city_id'] ?? null));
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];
                self::addCountryIndicator($data, $indicators);
                self::addCountryRegionIndicator($data, $indicators);   
                self::addCityIndicator($data, $indicators);
                return $indicators;
            });
    }
    /**
     * Method to create an address filter for use in FIlament tables.
     * @param string $relationshipName The relationship name for the address fields. Use the relationship name of the parent model to the address model.
     * @return Filter The filter component for the address filter.
     */
    public static function addressFilter(string $relationshipName): Filter{
        return Filter::make('Address')
            ->form([
                self::countryFilterField($relationshipName.'.city.countryRegion.country')
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        self::handleParentStateUpdated('country_region_id', CountryRegion::class, 'country_id', $set, $get, $state);
                    }),
                self::countryRegionFilterField($relationshipName.'.city.countryRegion')
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        self::handleParentStateUpdated('city_id', \App\Models\City::class, 'country_region_id', $set, $get, $state);
                    }),
                self::cityFilterField($relationshipName.'.city')
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        self::handleParentStateUpdated('city_postal_code_id', \App\Models\CityPostalCode::class, 'city_id', $set, $get, $state);
                    }),
                self::postalCodeFilterField($relationshipName)
            ])
            ->query(function (Builder $query, array $data) use($relationshipName): Builder {
                return $query
                    ->tap(fn($query) => self::setLocationFilter($query, $relationshipName.'.city.countryRegion.country','country_id', $data['country_id'] ?? null))
                    ->tap(fn($query) => self::setLocationFilter($query, $relationshipName.'.city.countryRegion', 'country_region_id', $data['country_region_id'] ?? null))
                    ->tap(fn($query) => self::setLocationFilter($query, $relationshipName.'.city', 'city_id', $data['city_id'] ?? null))
                    ->tap(fn($query) => self::setLocationFilter($query, $relationshipName, 'city_postal_code_id', $data['city_postal_code_id'] ?? null));
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];
                self::addCountryIndicator($data, $indicators);
                self::addCountryRegionIndicator($data, $indicators);   
                self::addCityIndicator($data, $indicators);
                self::addPostalCodeIndicator($data, $indicators);
                return $indicators;
            });
            
    }
}
