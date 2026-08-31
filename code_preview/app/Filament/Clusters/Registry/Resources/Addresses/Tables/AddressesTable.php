<?php

namespace App\Filament\Clusters\Registry\Resources\Addresses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use App\Filament\Schemas\AddressSchema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with([
                'cityPostalCode.city.administrativeDivisions'
            ]))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('cityPostalCode.city.countryRegion.country.name')
                    ->url(fn ($record) => \App\Filament\Clusters\Registry\Resources\Countries\CountryResource::getUrl('view', ['record' => $record->cityPostalCode?->city?->countryRegion?->country_id]))
                    ->label('Country Name')
                    ->searchable(),
                TextColumn::make('cityPostalCode.city.countryRegion.name')
                    ->url(fn ($record) => \App\Filament\Clusters\Registry\Resources\CountryRegions\CountryRegionResource::getUrl('view', ['record' => $record->cityPostalCode?->city?->country_region_id]))
                    ->label('Region Name')
                    ->searchable(),
                TextColumn::make('cityPostalCode.city.name')
                    ->url(fn ($record) => \App\Filament\Clusters\Registry\Resources\Cities\CityResource::getUrl('view', ['record' => $record->cityPostalCode?->city_id]))
                    ->label('City Name')
                    ->description(fn ($record) => $record->cityPostalCode?->city?->administrativeDivisions?->pluck('name')->implode(', '))
                    ->searchable(),
                TextColumn::make('cityPostalCode.postalCode.code')
                    ->url(fn ($record) => \App\Filament\Clusters\Registry\Resources\PostalCodes\PostalCodeResource::getUrl('view', ['record' => $record->cityPostalCode?->postal_code_id]))
                    ->label('Postal Code')
                    ->searchable(),
                TextColumn::make('street')
                    ->searchable(),
                TextColumn::make('building_number')
                    ->searchable(),
                TextColumn::make('apartment_number')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                AddressSchema::addressFilter('cityPostalCode'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
