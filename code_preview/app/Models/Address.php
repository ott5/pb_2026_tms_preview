<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
#[Fillable([ 'city_postal_code_id', 'street', 'building_number', 'apartment_number' ])]
class Address extends Model
{
    use HasFactory;

    public function cityPostalCode()
    {
        return $this->belongsTo(CityPostalCode::class, 'city_postal_code_id');
    }
    public function employeeAddresses()
    {
        return $this->hasMany(EmployeeAddress::class, 'address_id');
    }
}
