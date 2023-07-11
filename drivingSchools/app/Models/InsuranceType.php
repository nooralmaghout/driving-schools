<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class InsuranceType extends Model
{
    use HasFactory;
    protected $table = "insurance_types";

    protected $fillable = ["insurance_company_id ","type_of_insurance","price_of_type","price_of_car","offer "];

    public $timestamps = false;
    public function insurance_company()
    {
    return $this->belongsTo('App\Models\InsuranceCompany');
    }
    public function schedule(){
        return $this->hasMany('App\Models\Schedule','insurance_type_id','id');
    }
}
