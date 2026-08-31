<?php

namespace App\Filament\Clusters\System\Resources\Addresses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Schemas\AddressFields;
use Filament\Schemas\Components\Utilities\Set;

class AddressesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('postalCode.city.countryRegion.country.name')
                    ->label('Kraj')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('postalCode.city.countryRegion.name')
                    ->label('Region')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('postalCode.city.name')
                    ->label('Miejsowość')
                    ->searchable(),
                TextColumn::make('postalCode.code')
                    ->label('Kod pocztowy')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('street')
                    ->label('Ulica')
                    ->searchable(),
                TextColumn::make('building_number')
                    ->label('Numer budynku')
                    ->searchable(),
                TextColumn::make('apartment_number')
                    ->label('Numer mieszkania')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Data utworzenia')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Data modyfikacji')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('Address')
                    ->schema([
                        AddressFields::getCountrySelect('postalCode.city.countryRegion.country', 'name')
                            ->afterStateUpdated(function (Set $set){
                                $set('country_region_id', null);
                            }),
                        AddressFields::getCountryRegionSelect('postalCode.city.countryRegion', 'name')
                            ->afterStateUpdated(function (Set $set){
                                $set('city_id', null);
                            }),
                        AddressFields::getCitySelect('postalCode.city', 'name')
                            ->afterStateUpdated(function (Set $set){
                                $set('postal_code_id', null);
                            }),
                        AddressFields::getPostalCodeSelect(),
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
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
