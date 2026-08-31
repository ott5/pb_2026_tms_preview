<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
/**
 * app/Models/Address.php
 * Model reprezentujący adresy, przechowujący informacje o ulicy, numerze budynku, numerze mieszkania oraz powiązaniu z kodem pocztowym.
 */
class Address extends Model
{
    protected $fillable=['postal_code_id','street','building_number','apartment_number'];
    public function postalCode():BelongsTo{
        return $this->belongsTo(PostalCode::class);
    }
    public function employees():BelongsToMany{
        return $this->belongsToMany(Employee::class)
            ->withPivot('address_type_code')
            ->withTimestamps();
    }
    
}
