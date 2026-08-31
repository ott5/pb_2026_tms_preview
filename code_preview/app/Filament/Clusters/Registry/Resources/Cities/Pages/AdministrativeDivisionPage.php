<?php

namespace App\Filament\Clusters\Registry\Resources\Cities\Pages;
use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Tables\AdministrativeDivisionsAttachTable;
use App\Filament\Clusters\Registry\Resources\Cities\CityResource;
use Filament\Actions\DetachAction;
use Filament\Actions\AttachAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\BulkActionGroup;
use App\Filament\Schemas\AddressSchema;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Table;
//heroicons
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use BackedEnum;

class AdministrativeDivisionPage extends ManageRelatedRecords
{
    protected static string $resource = CityResource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingLibrary;

    protected static string $relationship = 'administrativeDivisions';


    public function table(Table $table): Table
    {
        return AdministrativeDivisionsAttachTable::configure($table)
            ->headerActions([
                AttachAction::make()                    
                    ->multiple()
                    ->preloadRecordSelect()
                    ->tableSelect(AdministrativeDivisionsAttachTable::class)
                    ->modalWidth('7xl')
            ])
            ->recordActions([
                ViewAction::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Division Name')
                            ->disabled(),
                        TextInput::make('type')
                            ->label('Division Type')
                            ->disabled(),
                        TextInput::make('code')
                            ->label('Division Code')
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
