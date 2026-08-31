<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * app/Models/VehicleCargoTankDetail.php
 * Model do tabeli szczegółów zbiorników ładunkowych pojazdów, zawierający informacje o typie zbiornika, klasie ciśnienia, ochronie termicznej, metodzie rozładunku, materiale oraz czy jest to pojazd ADR
 */
class VehicleCargoTankDetail extends Model
{
    protected $table='vehicle_cargo_tank_details';
    protected $fillable=[
        'vehicle_id',
        'tank_type_id',
        'pressure_class_id',
        'thermal_protection_id',
        'discharge_method_id',
        'material_id',
        'is_adr',
        'adr_id',
        'compartment_count'
    ];
    protected $casts=[
        'is_adr'=>'boolean',
    ];
    public function vehicle(): BelongsTo{
        return $this->belongsTo(Vehicle::class);
    }
    public function tankType(): BelongsTo{
        return $this->belongsTo(VehicleTankType::class);
    }
    public function pressureClass(): BelongsTo{
        return $this->belongsTo(VehicleTankPressureType::class);
    }
    public function thermalProtection(): BelongsTo{
        return $this->belongsTo(VehicleThermalProtectionType::class);
    }
    public function dischargeMethod(): BelongsTo{
        return $this->belongsTo(VehicleTankDischargeMethod::class);
    }
    public function material(): BelongsTo{
        return $this->belongsTo(VehicleBodyMaterial::class);
    }
    public function adrType(): BelongsTo{
        return $this->belongsTo(VehicleAdrType::class);
    }
}