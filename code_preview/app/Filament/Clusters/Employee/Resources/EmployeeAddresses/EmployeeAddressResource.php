<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeAddresses;

use App\Filament\Clusters\Employee\EmployeeCluster;
use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Pages\CreateEmployeeAddress;
use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Pages\EditEmployeeAddress;
use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Pages\ListEmployeeAddresses;
use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Pages\ViewEmployeeAddress;
use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Schemas\EmployeeAddressForm;
use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Tables\EmployeeAddressesTable;
use App\Models\EmployeeAddress;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeAddressResource extends Resource
{
    protected static ?string $model = EmployeeAddress::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeEuropeAfrica;

    protected static ?string $cluster = EmployeeCluster::class;

    protected static ?string $recordTitleAttribute = 'employee_id';

    public static function form(Schema $schema): Schema
    {
        return EmployeeAddressForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeeAddressesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployeeAddresses::route('/'),
            'create' => CreateEmployeeAddress::route('/create'),
            'view' => ViewEmployeeAddress::route('/{record}/'),
            'edit' => EditEmployeeAddress::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
