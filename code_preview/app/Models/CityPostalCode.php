<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
#[Fillable(['city_id', 'postal_code_id'])]
class CityPostalCode extends Model
{
    protected $table = 'city_postal_code';
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function postalCode()
    {
        return $this->belongsTo(PostalCode::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'city_postal_code_id');
    }
}
