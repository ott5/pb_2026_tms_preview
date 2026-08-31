<?php

namespace App\Filament\Clusters\Registry\Resources\CountryRegions;

use App\Filament\Clusters\Registry\RegistryCluster;
use App\Filament\Clusters\Registry\Resources\CountryRegions\Pages\CreateCountryRegion;
use App\Filament\Clusters\Registry\Resources\CountryRegions\Pages\EditCountryRegion;
use App\Filament\Clusters\Registry\Resources\CountryRegions\Pages\ListCountryRegions;
use App\Filament\Clusters\Registry\Resources\CountryRegions\Pages\ViewCountryRegion;
use App\Filament\Clusters\Registry\Resources\CountryRegions\Schemas\CountryRegionForm;
use App\Filament\Clusters\Registry\Resources\CountryRegions\Tables\CountryRegionsTable;
use App\Models\CountryRegion;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CountryRegionResource extends Resource
{
    protected static ?string $model = CountryRegion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeEuropeAfrica;

    protected static ?string $cluster = RegistryCluster::class;

    protected static string|UnitEnum|null $navigationGroup = 'Address';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CountryRegionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CountryRegionsTable::configure($table);
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
            'index' => ListCountryRegions::route('/'),
            'create' => CreateCountryRegion::route('/create'),
            'edit' => EditCountryRegion::route('/{record}/edit'),
            'view' => ViewCountryRegion::route('/{record}'),
        ];
    }
}
