<?php

namespace App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Tables;
use App\Filament\Clusters\Registry\Resources\Countries\CountryResource;
use App\Filament\Clusters\Registry\Resources\CountryRegions\CountryRegionResource;
use App\Filament\Schemas\AddressSchema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use App\Enums\DivisionType;
use Filament\Tables\Table;

class AdministrativeDivisionsTable
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
                Group::make('type')
                    ->label('Division Type')
                    ->collapsible(),
            ])
            ->collapsedGroupsByDefault()
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('type')
                    ->formatStateUsing(function ($state, $record) {
                        $countryCode = $record->countryRegion?->country?->code;
                        $value = $state instanceof DivisionType ? $state->value : $state;
                        $options = DivisionType::getLabelOptionsForCountry($countryCode);
                        return $options[$value] ?? ($state instanceof DivisionType ? $state->getLabel() : DivisionType::tryFrom($state)?->getLabel()) ?? $state;
                    })
                    ->badge(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('parent.name')
                    ->label('Parent Division')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('countryRegion.name')
                    ->numeric()
                    ->url(fn($record)=>CountryRegionResource::getUrl('view', ['record'=>$record->countryRegion?->country_id]))
                    ->sortable(),
                TextColumn::make('countryRegion.country.name')
                    ->label('Country')
                    ->sortable()
                    ->url(fn($record)=>CountryResource::getUrl('view', ['record'=>$record->countryRegion?->country_id]))
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
                SelectFilter::make('type')
                    ->label('Division Type')
                    ->multiple()
                    ->placeholder('Choose a division type')
                    ->options(DivisionType::class)
                    ->searchable(),
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
class AdministrativeDivisionsAttachTable extends AdministrativeDivisionsTable{
    public static function configure(Table $table): Table{
        parent::configure($table);
        return $table
            ->groups([
                group::make('type')
                    ->label('Division Type')
                    ->collapsible(),
            ])      
            ->columns([
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Division Type')
                    ->multiple()
                    ->placeholder('Choose a division type')
                    ->options([
                        'state' => 'State',
                        'province' => 'Province',
                        'region' => 'Region',
                        'district' => 'District',
                        'county' => 'County',
                        'municipality' => 'Municipality',
                        'other' => 'Other',
                    ])
                    ->searchable(),
            ]); 
    }
}