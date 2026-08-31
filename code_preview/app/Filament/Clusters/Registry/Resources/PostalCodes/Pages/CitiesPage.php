<?php

namespace App\Filament\Clusters\Registry\Resources\PostalCodes\Pages;

use App\Filament\Clusters\Registry\Resources\Cities\CityResource;
use App\Filament\Clusters\Registry\Resources\PostalCodes\PostalCodeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Actions\DetachAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Tables\Table;
use App\Filament\Clusters\Registry\Resources\Cities\Tables\CitiesTable;

class CitiesPage extends ManageRelatedRecords
{
    protected static string $resource = PostalCodeResource::class;

    protected static string $relationship = 'Cities';

    protected static ?string $relatedResource = CityResource::class;

    public function table(Table $table): Table
    {
        return CitiesTable::configure($table)
            ->headerActions([
                AttachAction::make()                    
                    ->multiple()
                    ->preloadRecordSelect()
                    ->tableSelect(CitiesTable::class)
                    ->modalWidth('7xl')
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
                DetachAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
