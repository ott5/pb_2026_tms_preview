<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Auth;
class EmployeeDocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('employee_id')
                    ->label('ID Pracownika')
                    ->required()
                    ->default(fn()=>Auth()->user()->employee?->id)
                    ->numeric(),
                Select::make('document_type_code')
                    ->label('Rodzaj dokumentu')
                    ->relationship('documentType','name')
                    ->required(),
                TextInput::make('number')
                    ->label('Numer dokumentu')
                    ->required(),
                DatePicker::make('issue_date')
                    ->label('Data wydania')
                    ->required()
                    ->live(),
                Select::make('issue_country_tag')
                    ->label('Kraj wydania')
                    ->relationship('issueCountry','name')
                    ->required(),
                DatePicker::make('expiry_date')
                    ->label('Data ważności')
                    ->after('issue_date')
                    ->required(),
                Select::make('attachment_id')
                    ->label('Załącznik')
                    ->relationship('attachment', 'file_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        FileUpload::make('url')
                            ->label('Wybierz plik')
                            ->disk('public')
                            ->directory('attachments')
                            ->required()
                            ->preserveFilenames()
                            ->afterStateUpdated(function($state,$set){
                                if(!$state) return;
                                $fileName=basename($state);
                                $set('file_name',$fileName);
                            }),
                        TextInput::make('file_name')
                            ->label('Nazwa pliku')
                            ->required(),
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                        Toggle::make('is_active')
                            ->label('Aktywny')
                            ->default(true),
                    ])
                    ->getOptionLabelUsing(fn ($record) => $record?->file_name ?? 'Wybierz plik'),
                Toggle::make('is_active')
                    ->label('Aktywny')
                    ->required()
                    ->default(true),
            ]);
    }
}
