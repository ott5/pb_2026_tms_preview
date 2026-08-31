<?php

namespace App\Filament\Clusters\Registry\Resources\Cities;

use App\Filament\Clusters\Registry\RegistryCluster;
use App\Filament\Clusters\Registry\Resources\Cities\Pages\CreateCity;
use App\Filament\Clusters\Registry\Resources\Cities\Pages\EditCity;
use App\Filament\Clusters\Registry\Resources\Cities\Pages\ListCities;
use App\Filament\Clusters\Registry\Resources\Cities\Pages\ViewCity;
use App\Filament\Clusters\Registry\Resources\Cities\Schemas\CityForm;
use App\Filament\Clusters\Registry\Resources\Cities\Tables\CitiesTable;
use App\Filament\Clusters\Registry\Resources\Cities\Pages\AdministrativeDivisionPage;
use App\Filament\Clusters\Registry\Resources\Cities\Pages\PostalCodePage;
use App\Models\City;
use Filament\Resources\Pages\Page;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static string|UnitEnum|null $navigationGroup = 'Address';

    protected static ?string $cluster = RegistryCluster::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CitiesTable::configure($table);
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
            'index' => ListCities::route('/'),
            'create' => CreateCity::route('/create'),
            'edit' => EditCity::route('/{record}/edit'),
            'view' => ViewCity::route('/{record}'),
            'administrative-divisions' => AdministrativeDivisionPage::route('/{record}/administrative-divisions'),
            'postal-codes' => PostalCodePage::route('/{record}/postal-codes'),
        ];
    }
    public static function getRecordSubnavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewCity::class,
            EditCity::class,
            AdministrativeDivisionPage::class,
            PostalCodePage::class,
        ]);
    }
}
