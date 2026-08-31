<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\AdministrativeDivisionFactory;
#[Fillable(['name', 'code', 'country_region_id', 'type', 'parent_id'])]
class AdministrativeDivision extends Model
{
    use HasFactory;
    public function countryRegion()
    {
        return $this->belongsTo(CountryRegion::class);
    }
    public function cities()
    {
        return $this->belongsToMany(City::class)
            ->where('country_region_id', $this->country_region_id);
    }
    public function parent()
    {
        return $this->belongsTo(AdministrativeDivision::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(AdministrativeDivision::class, 'parent_id');
    }
    protected function casts(): array
    {
        return [
            'type' => \App\Enums\DivisionType::class,
        ];
    }
}
