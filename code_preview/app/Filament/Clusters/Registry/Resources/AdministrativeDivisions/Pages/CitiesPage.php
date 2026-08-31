<?php

namespace App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Pages;

use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\AdministrativeDivisionResource;
use App\Filament\Clusters\Registry\Resources\Cities\CityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Table;
use App\Filament\Clusters\Registry\Resources\Cities\Tables\CitiesTable;
use Filament\Actions\DetachAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachBulkAction;

class CitiesPage extends ManageRelatedRecords
{
    protected static string $resource = AdministrativeDivisionResource::class;

    protected static string $relationship = 'cities';

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
