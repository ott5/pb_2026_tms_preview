<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\CityFactory;
#[Fillable(['name','code','country_region_id'])]
class City extends Model
{
    use HasFactory;
    public function countryRegion()
    {
        return $this->belongsTo(CountryRegion::class);
    }
    public function postalCodes()
    {
        return $this->belongsToMany(PostalCode::class)
            ->when($this->countryRegion?->country_id, fn ($q) => $q->where('country_id', $this->countryRegion->country_id));
    }
        public function administrativeDivisions()
    {
        return $this->belongsToMany(AdministrativeDivision::class)
            ->when($this->country_region_id, fn ($q) => $q->where('country_region_id', $this->country_region_id));
    }
}
