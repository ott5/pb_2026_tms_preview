<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeeAddresses\Pages;

use App\Filament\Clusters\Employee\Resources\EmployeeAddresses\EmployeeAddressResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Address;
use App\Models\CityPostalCode;
use Illuminate\Database\Eloquent\Model;
class CreateEmployeeAddress extends CreateRecord
{
    protected static string $resource = EmployeeAddressResource::class;
    public static function handleRecord(array $data): array{
        if(!empty($data['address'])){
            $postalCodeKey = $data['address']['city_postal_code_id'] ?? ($data['address']['postal_code_id'] ?? null);
            $address = Address::firstOrCreate(
                [
                    'street'              => $data['address']['street'] ?? null,
                    'building_number'     => $data['address']['building_number'] ?? null,
                    'apartment_number'    => $data['address']['apartment_number'] ?? null,
                    'city_postal_code_id' => $postalCodeKey,
                ],
            );
            
            $data['address_id'] = $address->id;
        }
        return $data;
    }
    protected function handleRecordCreation(array $data): Model
    {
        $data = self::handleRecord($data);
        unset($data['address']);
        
        return static::getModel()::updateOrCreate(
            [
                'employee_id' => $data['employee_id'],
                'type'        => $data['type'],
            ],
            [
                'address_id'  => $data['address_id'],
            ]
        );
    }
}