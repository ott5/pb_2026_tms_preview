<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * app/models/Vehicle.php
 * Model do tabeli pojazdów
 */
class Vehicle extends Model
{
    protected $table='vehicles';
    protected $fillable=[
        'registration_number',
        'owner_type_id',
        'vin',
        'mileage',
        'model_id',
        'production_year',
        'axle_configuration_type_id',
        'is_active'
    ];
    public function model(): BelongsTo{
        return $this->belongsTo(VehicleModel::class);
    }
    public function ownerType(): BelongsTo{
        return $this->belongsTo(VehicleOwnerType::class);
    }
    public function axleConfigurationType(): BelongsTo{
        return $this->belongsTo(VehicleAxleConfigurationType::class);
    }
    public $casts = [
        'is_active' => 'boolean',
        'production_year' => 'integer',
        'mileage' => 'integer'
    ];
}
