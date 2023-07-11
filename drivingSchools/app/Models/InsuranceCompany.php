<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class InsuranceCompany extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = "insurance_companies";

    protected $fillable = ["name","email","password","about","location","city"];

    public $timestamps = false;

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
    public function insurance_type(){
        return $this->hasMany('App\Models\InsuranceType','insurance_company_id','id');
    }
}
