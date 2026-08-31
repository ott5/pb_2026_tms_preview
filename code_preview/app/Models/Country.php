<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
#[Fillable(['name','code','nationality'])]
class Country extends Model
{    
    public function countryRegions()
    {
        return $this->hasMany(CountryRegion::class);
    }
}
