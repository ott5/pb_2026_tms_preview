<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use app\Filament\Clusters\Employee\Resources\Employees\EmployeeResource;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Schemas\AddressSchema;
use Filament\Tables\Grouping\Group;
use App\Enums\AddressType;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class EmployeeAddressesTable
{
    public static function configure(Table $table): Table
    {
        return $table
                ->groups([
                Group::make('employee.employee_number')
                    ->label('Employee')
                    ->getDescriptionFromRecordUsing(fn ($record) => "{$record->employee?->first_name} {$record->employee?->last_name}"),
                
                Group::make('type')
                    ->label('Address Type')
                    ->collapsible(),
            ])
            ->columns([
                TextColumn::make('employee.employee_number')
                    ->label('Employee Number')
                    ->color('danger')
                    ->url(fn ($record) => EmployeeResource::getUrl('view', ['record' => $record->employee_id]))
                    ->description(fn ($record) => $record->employee?->first_name . ' ' . $record->employee?->last_name)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('address.cityPostalCode.city.countryRegion.name')
                    ->label('Region Name')
                    ->description(fn ($record) => $record->address?->cityPostalCode?->city?->countryRegion?->country?->name)
                    ->default('—')
                    ->searchable(),
                TextColumn::make('address.cityPostalCode.city.name')
                    ->label('City Name')
                    ->description(fn ($record) => $record->address?->cityPostalCode?->city?->administrativeDivisions?->pluck('name')->implode(', '))
                    ->default('—')
                    ->searchable(),
                TextColumn::make('address.cityPostalCode.postalCode.code')
                    ->label('Postal Code')
                    ->default('—')
                    ->searchable(),
                TextColumn::make('address.street')
                    ->label('Street')
                    ->default('—')
                    ->searchable(),
                TextColumn::make('address.building_number')
                    ->label('Building Number')
                    ->default('—')
                    ->searchable(),
                TextColumn::make('address.apartment_number')
                    ->label('Apartment Number')
                    ->default('—')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                AddressSchema::addressFilter('address.CityPostalCode'),
                SelectFilter::make('type')
                    ->label('Address Type')
                    ->options(AddressType::class)
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
                RestoreAction::make()
                    ->iconButton(),
                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
