<?php

namespace App\Filament\Clusters\Registry\Resources\Addresses;

use App\Filament\Clusters\Registry\RegistryCluster;
use App\Filament\Clusters\Registry\Resources\Addresses\Pages\CreateAddress;
use App\Filament\Clusters\Registry\Resources\Addresses\Pages\EditAddress;
use App\Filament\Clusters\Registry\Resources\Addresses\Pages\ListAddresses;
use App\Filament\Clusters\Registry\Resources\Addresses\Pages\ViewAddress;
use App\Filament\Clusters\Registry\Resources\Addresses\Schemas\AddressForm;
use App\Filament\Clusters\Registry\Resources\Addresses\Schemas\AddressInfolist;
use App\Filament\Clusters\Registry\Resources\Addresses\Tables\AddressesTable;
use App\Models\Address;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::MapPin;

    protected static string|UnitEnum|null $navigationGroup = 'Address';

    protected static ?string $cluster = RegistryCluster::class;

    protected static ?string $recordTitleAttribute = 'street';

    public static function form(Schema $schema): Schema
    {
        return AddressForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddressesTable::configure($table);
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
            'index' => ListAddresses::route('/'),
            'create' => CreateAddress::route('/create'),
            'view' => ViewAddress::route('/{record}'),
            'edit' => EditAddress::route('/{record}/edit'),
        ];
    }
}
