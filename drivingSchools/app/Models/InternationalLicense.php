<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class InternationalLicense extends Model
{
    use HasFactory;

    protected $table = "international_licenses";

    protected $fillable = ["international_office_id","student_id","date_of_granting","date_of_expiring"];

    public $timestamps = false;
    
    public function schedule(){
        return $this->hasMany('App\Models\Schedule','international_license_id','id');
    }
    public function student()
    {
    return $this->belongsTo('App\Models\Student');
    }
    public function international_office()
    {
    return $this->belongsTo('App\Models\InternationalOffice');
    }
}
