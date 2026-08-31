<?php

namespace App\Filament\Clusters\Vehicle\Resources\Vehicles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Podstawowe informacje')
                    ->schema([
                        self::getVehicleTypeSelect()
                            ->afterStateHydrated(fn (Set $set, ?Model $record) => 
                                $set('vehicleType_id', $record?->model?->vehicleType?->id)
                            )
                            ->required(),
                        self::getVehicleBrandSelect()
                            ->afterStateHydrated(fn (Set $set, ?Model $record)=> 
                                $set('brand_id', $record?->model?->vehicleBrand?->id)
                            )
                            ->required(),
                        self::getVehicleModelSelect()
                            ->required(),
                        self::getAxleConfigurationTypeSelect()   
                            ->required(),
                        TextInput::make('production_year')
                            ->label('Rok produkcji')                
                            ->required(), 
                        ])
                    ->columns(3),
                //-------------------------------------------------------                
                Section::make('Dodatkowe informacje')
                    ->schema([
                        TextInput::make('registration_number')      
                            ->label('Numer rejestracyjny'),              
                        TextInput::make('vin'),
                        Select::make('owner_type_id')
                            ->label('Typ właściciela')
                            ->relationship('ownerType', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('mileage')
                            ->label('Przebieg')
                            ->numeric()
                            ->required()
                            ->numeric(),
                        Toggle::make('is_active')
                            ->label('Aktywny')
                            ->default(true)
                            ->required(),
                        ])
                    ->columns(2),                        
            ]);
    }
    public static function getVehicleTypeSelect(): Select{
        return Select::make('vehicleType_id')
            ->label('Typ pojazdu')
            ->live()
            ->relationship('model.vehicleType', 'name')            
            ->afterStateUpdated(function (Set $set){
                $set('brand_id', null);
                $set('model_id', null);
                $set('axle_configuration_type_id', null);
            })
            ->searchable()
            ->preload();
    }
    public static function getVehicleBrandSelect():Select{
        return Select::make('brand_id')
            ->label('Marka pojazdu')
            ->live()
            ->disabled(fn ($get) => empty($get('vehicleType_id')))
            ->relationship(
                name: 'model.vehicleBrand', 
                titleAttribute: 'name',
                modifyQueryUsing: fn (Builder $query,Get $get) 
                    =>$query->whereHas('models', fn($q)
                        =>$q->where('vehicle_type_id', $get('vehicleType_id'))),
            )            
            ->afterStateUpdated(function (Set $set){
                $set('model_id', null);
                $set('axle_configuration_type_id', null);
            })
            ->searchable()
            ->preload();
    }
    public static function getVehicleModelSelect(): Select{
        return Select::make('model_id')
            ->label('Model')
            ->live()
            ->disabled(fn ($get) => empty($get('brand_id')))
            ->relationship(
                name: 'model',
                titleAttribute:'name',
                modifyQueryUsing: fn (Builder $query,Get $get) 
                    =>$query->where('vehicle_brand_id', $get('brand_id')),
            )
            ->afterStateUpdated(function (Set $set){
                $set('axle_configuration_type_id', null);
            })
            ->searchable()
            ->preload();
    }
    public static function getAxleConfigurationTypeSelect(): Select{
        return Select::make('axle_configuration_type_id')
            ->label('Konfiguracja osi')
            ->disabled(fn ($get) => empty($get('model_id')))
            ->relationship(
                name: 'axleConfigurationType',
                titleAttribute: 'code',
                modifyQueryUsing: function (Builder $query, Get $get){
                    $typeId = (int) $get('vehicleType_id');
                    return match ($typeId){
                        1,3,4,5 => $query->where('driven_axle_count','>',0), //Dla pojazdów ciężarowych, aut dostawczych, traktorów, aut osobowych.
                        2 => $query->where('driven_axle_count','=',0), //Dla przyczep
                        default => $query, //Dla innych typów pojazdów brak dodatkowych kryteriów
                    };
                }
            )            
            ->searchable()
            ->preload();
    }
}
