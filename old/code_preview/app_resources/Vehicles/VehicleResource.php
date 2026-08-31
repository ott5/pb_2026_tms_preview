<?php

namespace App\Filament\Clusters\Vehicle\Resources\Vehicles;

use App\Filament\Clusters\Vehicle\Resources\Vehicles\Pages\CreateVehicle;
use App\Filament\Clusters\Vehicle\Resources\Vehicles\Pages\EditVehicle;
use App\Filament\Clusters\Vehicle\Resources\Vehicles\Pages\ListVehicles;
use App\Filament\Clusters\Vehicle\Resources\Vehicles\Schemas\VehicleForm;
use App\Filament\Clusters\Vehicle\Resources\Vehicles\Tables\VehiclesTable;
use App\Filament\Clusters\Vehicle\VehicleCluster;
use App\Models\Vehicle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $cluster = VehicleCluster::class;

    protected static ?string $recordTitleAttribute = 'registration_number';
    protected static ?string $pluralModelLabel = 'Pojazdy';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-truck';

    public static function form(Schema $schema): Schema
    {
        return VehicleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehiclesTable::configure($table);
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
            'index' => ListVehicles::route('/'),
            'create' => CreateVehicle::route('/create'),
            'edit' => EditVehicle::route('/{record}/edit'),
        ];
    }
}
