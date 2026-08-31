<?php

namespace App\Filament\Clusters\System\Resources\Addresses;

use App\Filament\Clusters\System\Resources\Addresses\Pages\CreateAddress;
use App\Filament\Clusters\System\Resources\Addresses\Pages\EditAddress;
use App\Filament\Clusters\System\Resources\Addresses\Pages\ListAddresses;
use App\Filament\Clusters\System\Resources\Addresses\Schemas\AddressForm;
use App\Filament\Clusters\System\Resources\Addresses\Tables\AddressesTable;
use App\Filament\Clusters\System\SystemCluster;
use App\Models\Address;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $cluster = SystemCluster::class;

    protected static ?string $recordTitleAttribute = 'street';
    protected static ?string $pluralModelLabel = 'Adresy';

    protected static string | UnitEnum | null $navigationGroup = 'Zarządzanie adresami';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

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
            'edit' => EditAddress::route('/{record}/edit'),
        ];
    }
}
