<?php

namespace App\Filament\Clusters\Registry\Resources\AdministrativeDivisions;

use App\Filament\Clusters\Registry\RegistryCluster;
use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Pages\CreateAdministrativeDivision;
use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Pages\EditAdministrativeDivision;
use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Pages\ListAdministrativeDivisions;
use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Schemas\AdministrativeDivisionForm;
use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Tables\AdministrativeDivisionsTable;
use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Pages\ViewAdministrativeDivision;
use App\Models\AdministrativeDivision;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Resources\Pages\Page;
use App\Filament\Clusters\Registry\Resources\AdministrativeDivisions\Pages\CitiesPage;

class AdministrativeDivisionResource extends Resource
{
    protected static ?string $model = AdministrativeDivision::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Address';

    protected static ?string $cluster = RegistryCluster::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AdministrativeDivisionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdministrativeDivisionsTable::configure($table);
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
            'index' => ListAdministrativeDivisions::route('/'),
            'create' => CreateAdministrativeDivision::route('/create'),
            'edit' => EditAdministrativeDivision::route('/{record}/edit'),
            'view' => ViewAdministrativeDivision::route('/{record}'),
            'cities' => CitiesPage::route('/{record}/cities'),
        ];
    }
    public static function getRecordSubnavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewAdministrativeDivision::class,
            EditAdministrativeDivision::class,
            CitiesPage::class,
        ]);
    }
}
