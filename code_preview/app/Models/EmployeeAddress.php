<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Enums\AddressType;
#[Fillable(['employee_id', 'address_id', 'type'])]
class EmployeeAddress extends Model
{
    use SoftDeletes; 
    protected function casts(): array
    {
        return [
            'type' => AddressType::class,
        ];
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
   
}
