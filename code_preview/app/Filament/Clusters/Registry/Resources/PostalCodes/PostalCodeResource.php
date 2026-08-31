<?php

namespace App\Filament\Clusters\Registry\Resources\PostalCodes;

use App\Filament\Clusters\Registry\RegistryCluster;
use App\Filament\Clusters\Registry\Resources\PostalCodes\Pages\CreatePostalCode;
use App\Filament\Clusters\Registry\Resources\PostalCodes\Pages\EditPostalCode;
use App\Filament\Clusters\Registry\Resources\PostalCodes\Pages\ListPostalCodes;
use App\Filament\Clusters\Registry\Resources\PostalCodes\Pages\ViewPostalCode;
use App\Filament\Clusters\Registry\Resources\PostalCodes\Schemas\PostalCodeForm;
use App\Filament\Clusters\Registry\Resources\PostalCodes\Tables\PostalCodesTable;
use App\Models\PostalCode;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Clusters\Registry\Resources\PostalCodes\Pages\CitiesPage;

class PostalCodeResource extends Resource
{
    protected static ?string $model = PostalCode::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;

    protected static string|UnitEnum|null $navigationGroup = 'Address';

    protected static ?string $cluster = RegistryCluster::class;

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return PostalCodeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostalCodesTable::configure($table);
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
            'index' => ListPostalCodes::route('/'),
            'create' => CreatePostalCode::route('/create'),
            'view' => ViewPostalCode::route('/{record}'),
            'edit' => EditPostalCode::route('/{record}/edit'),
            'cities' => CitiesPage::route('/{record}/cities'),
        ];
    }
    public static function getRecordSubnavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewPostalCode::class,
            EditPostalCode::class,
            CitiesPage::class,
        ]);
    }
}
