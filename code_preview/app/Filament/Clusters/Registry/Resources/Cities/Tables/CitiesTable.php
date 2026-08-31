<?php

namespace App\Filament\Clusters\Registry\Resources\Cities\Tables;

use App\Filament\Clusters\Registry\Resources\CountryRegions\CountryRegionResource;
use App\Filament\Clusters\Registry\Resources\Countries\CountryResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Schemas\AddressSchema;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
class CitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('countryRegion.country.name')
                    ->label("Country")
                    ->collapsible(),
                Group::make('countryRegion.name')
                    ->label('Country Region')
                    ->collapsible(),
            ])
            ->collapsedGroupsByDefault()
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('name')
                    ->label('City Name')
                    ->searchable(),
                TextColumn::make('countryRegion.name')
                    ->url(fn ($record) => CountryRegionResource::getUrl('view', ['record' => $record->country_region_id]))
                    ->label('Region Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('countryRegion.country.name')
                    ->url(fn ($record) => CountryResource::getUrl('view', ['record' => $record->countryRegion?->country_id]))
                    ->label('Country Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('postalCodes')
                    ->listWithLineBreaks()
                    ->getStateUsing(fn ($record) => $record->postalCodes->pluck('code')->toArray())                
                    ->limitList(3)
                    ->label('Postal codes')
                    ->listWithLineBreaks(),
                TextColumn::make('administrativeDivisions')
                    ->label('Administrative Divisions')
                    ->listWithLineBreaks()
                    ->getStateUsing(fn ($record) => $record->administrativeDivisions->pluck('name')->toArray())
                    ->listWithLineBreaks()
                    ->limitList(2)
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
                AddressSchema::cityFilter('countryRegion'),
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
