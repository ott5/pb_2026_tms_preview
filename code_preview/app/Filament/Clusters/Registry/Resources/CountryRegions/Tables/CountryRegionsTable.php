<?php

namespace App\Filament\Clusters\Registry\Resources\CountryRegions\Tables;

use App\Filament\Clusters\Registry\Resources\Countries\CountryResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountryRegionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('country.name')
                    ->label("Country")
                    ->collapsible(),
            ])
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Region Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('code')
                    ->label('Region Code')
                    ->searchable(),
                TextColumn::make('country.name')
                    ->label('Country')
                    ->tooltip("Click to see country details")
                    ->url(fn ($record): ?string => CountryResource::getUrl('view', ['record' => $record->country_id]))
                    ->sortable()
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
                SelectFilter::make('country_id')
                    ->label('Country')
                    ->placeholder('Choose a country')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload(),
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
