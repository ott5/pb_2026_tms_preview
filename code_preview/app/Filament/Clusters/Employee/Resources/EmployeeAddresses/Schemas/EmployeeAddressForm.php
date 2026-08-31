<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use App\Enums\AddressType;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Filament\Clusters\Registry\Resources\Addresses\Schemas\AddressForm;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Schemas\Components\Grid;
use App\Filament\Clusters\Employee\Resources\Employees\Tables\EmployeesTable;
use App\Models\Employee;
use App\Filament\Schemas\AddressSchema;
use App\Models\Address;

class EmployeeAddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Employee')
                    ->columns(2)
                    ->schema([
                        ModalTableSelect::make('employee_id')
                            ->label('Employee')
                            ->tableConfiguration(EmployeesTable::class)
                            ->relationship('employee', 'employee_number')
                            ->getOptionLabelFromRecordUsing(fn (Employee $record): string => "{$record->employee_number} - {$record->first_name} {$record->last_name}")
                            ->required(),
                        Select::make('type')
                            ->label('Address Type')
                            ->placeholder('Choose an address type')
                            ->options(AddressType::class)
                            ->required(),
                    ]),
                Section::make('Address')
                    ->model(Address::class)
                    ->statePath('address')
                    ->schema([
                        Grid::make(2)->schema([
                            AddressSchema::countrySelect('cityPostalCode.city.countryRegion.country'),
                            AddressSchema::countryRegionSelect('cityPostalCode.city.countryRegion')
                                ->disabled(fn($get)=>empty($get('country_id'))),
                            AddressSchema::citySelect('cityPostalCode.city')
                                ->afterStateUpdated(function ($set) {
                                    $set('city_postal_code_id', null);
                                })
                                ->disabled(fn($get)=>empty($get('country_region_id'))),
                            AddressSchema::postalCodeSelect('cityPostalCode')
                                ->live()
                                ->disabled(fn($get)=>empty($get('city_id'))),
                            TextInput::make('street'),
                            TextInput::make('building_number')->required(),
                            TextInput::make('apartment_number'),
                        ])
                    ])
            ]); 
        }
}