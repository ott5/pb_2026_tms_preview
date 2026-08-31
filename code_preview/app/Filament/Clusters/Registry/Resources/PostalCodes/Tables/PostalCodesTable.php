<?php

namespace App\Filament\Clusters\Registry\Resources\PostalCodes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;

class PostalCodesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('country.name')
                    ->label("Country")
                    ->collapsible(),
            ])
            ->collapsedGroupsByDefault()
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('country.name')
                    ->numeric()
                    ->url(fn ($record) => \App\Filament\Clusters\Registry\Resources\Countries\CountryResource::getUrl('view', ['record' => $record->country_id]))
                    ->sortable(),
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
                    ->relationship('country', 'name')
                    ->searchable()
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
