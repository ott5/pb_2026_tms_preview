<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeDocuments;

use App\Filament\Clusters\Employee\EmployeeCluster;
use App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Pages\CreateEmployeeDocument;
use App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Pages\EditEmployeeDocument;
use App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Pages\ListEmployeeDocuments;
use App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Schemas\EmployeeDocumentForm;
use App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Tables\EmployeeDocumentsTable;
use App\Models\EmployeeDocument;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EmployeeDocumentResource extends Resource
{
    protected static ?string $model = EmployeeDocument::class;

    protected static ?string $cluster = EmployeeCluster::class;

    protected static ?string $recordTitleAttribute = 'employee_id';
    protected static ?string $pluralModelLabel = 'Dokumenty';

    protected static string | UnitEnum | null $navigationGroup = 'Zarządzanie pracownikami';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function form(Schema $schema): Schema
    {
        return EmployeeDocumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeeDocumentsTable::configure($table);
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
            'index' => ListEmployeeDocuments::route('/'),
            'create' => CreateEmployeeDocument::route('/create'),
            'edit' => EditEmployeeDocument::route('/{record}/edit'),
        ];
    }
}
