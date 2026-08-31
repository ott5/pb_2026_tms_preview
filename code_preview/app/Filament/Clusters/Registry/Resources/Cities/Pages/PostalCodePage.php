<?php

namespace App\Filament\Clusters\Registry\Resources\Cities\Pages;

use App\Filament\Clusters\Registry\Resources\Cities\CityResource;
use App\Filament\Clusters\Registry\Resources\PostalCodes\PostalCodeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Actions\DetachAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachBulkAction;
use App\Filament\Clusters\Registry\Resources\PostalCodes\Tables\PostalCodesTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;

class PostalCodePage extends ManageRelatedRecords
{
    protected static string $resource = CityResource::class;

    protected static string $relationship = 'postalCodes';

    protected static ?string $relatedResource = PostalCodeResource::class;

    public function table(Table $table): Table
    {
        return PostalCodesTable::configure($table)
            ->headerActions([
                AttachAction::make()                    
                    ->multiple()
                    ->preloadRecordSelect()
                    ->tableSelect(PostalCodesTable::class)
                    ->modalWidth('7xl')
            ])
            ->recordActions([
                ViewAction::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Postal Code')
                            ->disabled(),
                    ])
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
