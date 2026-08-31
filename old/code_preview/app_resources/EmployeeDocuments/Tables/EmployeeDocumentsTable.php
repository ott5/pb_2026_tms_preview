<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeDocuments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Clusters\Employee\Resources\Employees\EmployeeResource;
use App\Filament\Clusters\System\Resources\Attachments\AttachmentsResource;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
class EmployeeDocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('employee_id')
                    ->label('ID Pracownika')
                    ->tooltip(fn ($record): string => "{$record->employee->first_name} {$record->employee->last_name} {$record->employee->employee_number}")
                    ->url(fn ($record)=>$record->employee_id
                        ?EmployeeResource::getUrl('edit', ['record' => $record->employee_id]):null)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('documentType.name')
                    ->label('Rodzaj dokumentu')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('number')
                    ->label('Numer dokumentu')
                     ->sortable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('issue_date')
                    ->label('Data wydania')
                    ->date()
                    ->sortable(),
                TextColumn::make('issueCountry.name')
                    ->label('Kraj wydania')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('expiry_date')
                    ->label('Data ważności')
                    ->date()
                    ->badge()
                    ->tooltip(function ($state) {
                        $date = Carbon::parse($state);
                        $now = now()->startOfDay();                        
                        if ($date->isPast()) return 'Wygasło ' . $date->diffInDays($now) . ' dni temu';
                        if ($date->isToday()) return 'Wygasa dzisiaj!';
                        return 'Pozostało dni: ' . $now->diffInDays($date);
                    })
                    ->color(fn ($state): string => match (true) {
                        Carbon::parse($state)->isPast() => 'danger',
                        Carbon::parse($state)->lessThanOrEqualTo(now()->addDays(7)) => 'warning',
                        default => 'success',
                    })
                    ->sortable(),
                TextColumn::make('attachment_id')
                    ->label('Załącznik')    
                    ->tooltip(fn ($record): string => "{$record->attachment->file_name} {$record->attachment->url}")
                    ->url(fn ($record)=>$record->attachment_id
                        ?AttachmentsResource::getUrl('edit', ['record' => $record->attachment_id]):null)
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktywny')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Aktywny')
                    ->trueLabel('Tak')
                    ->falseLabel('Nie')
                    ->default(true),
                SelectFilter::make('issue_country_tag')
                    ->label('Kraj wydania')
                    ->relationship('issueCountry', 'name')
                    ->multiple(),
                SelectFilter::make('documentType_id')
                    ->label('Rodzaj dokumentu')
                    ->relationship('documentType', 'name')
                    ->multiple(),
                Filter::make('expired_only')
                    ->label('Dokumenty nieważne')
                    ->query(fn (Builder $query): Builder => $query->where('expiry_date', '<', now())),
                Filter::make('expiring_soon')
                    ->label('Dokumenty wygasające (7dni)')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('expiry_date', [
                        now(), 
                        now()->addDays(7)
                    ])),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
