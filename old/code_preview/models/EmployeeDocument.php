<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * app/Models/EmployeeDocument.php
 * Model reprezentujący dokumenty pracowników w systemie, przechowujący informacje o rodzaju dokumentu, numerze, dacie wydania, kraju wydania, dacie ważności oraz powiązaniu z pracownikiem. Dokumenty mogą być aktywne lub nieaktywne, co pozwala na zarządzanie ważnością dokumentów pracowników w systemie.
 */
class EmployeeDocument extends Model
{
    protected $table='employee_documents';
    protected $fillable=['employee_id','document_type_code','number','issue_date','issue_country_tag','expiry_date','attachment_id','is_active'];
    public function employee(): BelongsTo{
        return $this->belongsTo(Employee::class);
    }
    public function documentType(): BelongsTo{
        return $this->belongsTo(DocumentType::class,'document_type_code','code');
    }
    public function issueCountry(): BelongsTo{
        return $this->belongsTo(Country::class,'issue_country_tag','tag');
    }
    public function attachment(): BelongsTo{
        return $this->belongsTo(Attachments::class);
    }
    protected $casts=['is_active'=>'boolean'];
    protected static function booted(){
        static::saving(function($employeeDocument){
            if($employeeDocument->expiry_date <= $employeeDocument->issue_date){
                throw new \InvalidArgumentException("Expiry date must be greater than issue date for employee document with number: {$employeeDocument->number}");
            }
        });
    }
}
