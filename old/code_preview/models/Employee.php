<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\EmployeeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
/**
 * app/Models/Employee.php
 * Model reprezentujący pracowników w systemie, przechowujący informacje o imieniu, nazwisku, numerze pracownika, aktywności oraz powiązaniu z użytkownikiem. Pracownicy mogą mieć przypisane narodowości oraz adresy, co pozwala na zarządzanie danymi personalnymi i kontaktowymi pracowników w systemie.
 */
#[ObservedBy(EmployeeObserver::class)]
class Employee extends Model
{
    protected $table='employees';
    protected $fillable=['first_name','second_name','last_name','employee_number','user_id','is_active'];
    protected $casts=['is_active'=>'boolean'];
    public static function generateEmployeeNumber(): string{
        $prefix = 'EMP/'.date('Y').'/';
        do{
            $number = $prefix.str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while(Employee::where('employee_number', $number)->exists());
        return $number;
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function nationalities():BelongsToMany{
        return $this->belongsToMany(Country::class,'employee_nationalities','employee_id','country_tag','id','tag')
            ->withTimestamps();
    }
    public function addresses():BelongsToMany{
        return $this->belongsToMany(Address::class)
            ->withPivot('address_type_code')
            ->withTimestamps();
    }
    public function phoneNumbers():BelongsToMany{
        return $this->belongsToMany(PhoneNumber::class,'employee_phone_number','employee_id','phone_number','id','number')
            ->withPivot('phone_usage_type_code')
            ->withTimestamps();
    }
    public function emails(){
        return $this->user->emails();
    }
    public function moreInformation():HasOne{
        return $this->hasOne(EmployeeMoreInformation::class);
    }
    public function documents():HasMany{
        return $this->hasMany(EmployeeDocument::class);
    }
    public function medicalExams():HasMany{
        return $this->hasMany(EmployeeMedicalExam::class);
    }
    public function licenseExperiences():HasMany{
        return $this->hasMany(EmployeeLicenseExperience::class);
    }
    public function driver():HasOne{
        return $this->hasOne(Driver::class);
    }
    public function isDriver(){
        return $this->driver()->exists();
    }
    
}
