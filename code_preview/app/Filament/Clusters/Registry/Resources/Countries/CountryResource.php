<?php

namespace App\Filament\Clusters\Registry\Resources\Countries;

use App\Filament\Clusters\Registry\RegistryCluster;
use App\Filament\Clusters\Registry\Resources\Countries\Pages\CreateCountry;
use App\Filament\Clusters\Registry\Resources\Countries\Pages\EditCountry;
use App\Filament\Clusters\Registry\Resources\Countries\Pages\ListCountries;
use App\Filament\Clusters\Registry\Resources\Countries\Pages\ViewCountry;
use App\Filament\Clusters\Registry\Resources\Countries\Schemas\CountryForm;
use App\Filament\Clusters\Registry\Resources\Countries\Tables\CountriesTable;
use App\Models\Country;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Flag;

    protected static ?string $cluster = RegistryCluster::class;

    protected static string|UnitEnum|null $navigationGroup = 'Address';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CountryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CountriesTable::configure($table);
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
            'index' => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'edit' => EditCountry::route('/{record}/edit'),
            'view' => ViewCountry::route('/{record}'),
        ];
    }
}
