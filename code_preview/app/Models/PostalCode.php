<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\PostalCodeFactory;
#[Fillable(['code', 'country_id'])]
class PostalCode extends Model
{
    use HasFactory;
    public function cities()
    {
        return $this->belongsToMany(City::class)
            ->whereHas('countryRegion', function ($query) {
                $query->where('country_id', $this->country_id);
            });
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
