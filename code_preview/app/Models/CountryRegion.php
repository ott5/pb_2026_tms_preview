<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
#[Fillable(['name','code','country_id'])]
class CountryRegion extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
