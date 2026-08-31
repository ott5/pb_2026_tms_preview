<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Pages;

use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\EmployeeAddressResource;
use App\Models\Address;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditEmployeeAddress extends EditRecord
{
    protected static string $resource = EmployeeAddressResource::class;

    public static function getFormData(?Model $record): array
    {
        if(!$record) return [];
        $address = $record->address()
            ->with('cityPostalCode.city.countryRegion.country')
            ->first();
            
        if ($address) {
            $cityPostalCode = $address->cityPostalCode;
            $city = optional($cityPostalCode)->city;
            $region = optional($city)->countryRegion;
            return [
            'address' => [
                'street'              => $address->street,
                'building_number'     => $address->building_number,
                'apartment_number'    => $address->apartment_number,
                'city_postal_code_id' => $address->city_postal_code_id,
                'city_id'             => optional($city)->id,
                'country_region_id'   => optional($region)->id,
                'country_id'          => optional($region)->country_id,
            ]
        ];
        }
        return [];
    }
    protected function mutateFormDataBeforeFill(array $data): array{
        return array_merge($data, self::getFormData($this->record));
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $data = CreateEmployeeAddress::handleRecord($data);
        
        unset($data['address']);
        $record->update($data);

        return $record;
    }
}