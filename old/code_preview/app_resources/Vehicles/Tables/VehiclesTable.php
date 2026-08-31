<?php

namespace App\Filament\Clusters\Vehicle\Resources\Vehicles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Clusters\Vehicle\Resources\Vehicles\Schemas\VehicleForm;
use Filament\Tables\Table;

class VehiclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('model.vehicleType.name')                
                    ->label('Typ pojazdu')
                    ->badge()
                    ->sortable(),
                TextColumn::make('registration_number')
                    ->label('Numer rejestracyjny')
                    ->searchable(),
                TextColumn::make('ownerType.name')
                    ->label('Typ właściciela')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vin')
                    ->label('Numer VIN')
                    ->searchable(),
                TextColumn::make('mileage')
                    ->label('Przebieg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('model.name')
                    ->label('Model')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('production_year')
                    ->label('Rok produkcji')
                    ->badge()
                    ->date('yyyy')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('axleConfigurationType.code')
                    ->label('Konfiguracja osi')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktywny')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Data utworzenia')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Data aktualizacji')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([   
                Filter::make('vehicleType_id')
                    ->label('Typ pojazdu')
                    ->schema([
                        VehicleForm::getVehicleTypeSelect(),
                        VehicleForm::getVehicleBrandSelect(),
                        VehicleForm::getVehicleModelSelect(),
                        VehicleForm::getAxleConfigurationTypeSelect(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['vehicleType_id'] ?? null, function (Builder $query, $typeId) {
                                $query->whereRelation('model', 'vehicle_type_id', $typeId);
                            })
                            ->when($data['brand_id'] ?? null, function (Builder $query, $brandId) {
                                $query->whereRelation('model', 'vehicle_brand_id', $brandId);
                            })
                            ->when($data['model_id'] ?? null, function (Builder $query, $modelId) {
                                $query->where('model_id', $modelId);
                            })
                            ->when($data['axle_configuration_type_id'] ?? null, function (Builder $query, $axleId) {
                                $query->where('axle_configuration_type_id', $axleId);
                            });
                    })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];
                        if ($data['vehicleType_id'] ?? null) {
                            $name=\App\Models\VehicleType::find($data['vehicleType_id'])?->name;
                            $indicators[] = "Typ pojazdu: {$name}";
                        }
                        if ($data['brand_id'] ?? null) {
                            $name=\App\Models\VehicleBrand::find($data['brand_id'])?->name;
                            $indicators[] = "Marka: {$name}";
                        }
                        if ($data['model_id'] ?? null) {
                            $name=\App\Models\VehicleModel::find($data['model_id'])?->name;
                            $indicators[] = "Model: {$name}";
                        }
                        if ($data['axle_configuration_type_id'] ?? null) {
                            $name=\App\Models\VehicleAxleConfigurationType::find($data['axle_configuration_type_id'])?->code;
                            $indicators[] = "Konfiguracja osi: {$name}";
                        }
                        return $indicators;
                    }),
                SelectFilter::make('owner_type_id')
                    ->label('Typ właściciela')
                    ->relationship(
                        name: 'ownerType',
                        titleAttribute: 'name'
                    )
                    ->preload(),
                TernaryFilter::make('is_active')
                    ->label('Aktywny'),
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
