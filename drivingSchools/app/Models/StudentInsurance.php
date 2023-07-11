<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class StudentInsurance extends Model
{
    use HasFactory;
    protected $table = "student_insurances";

    protected $fillable = [
        "student_id",
        "insurance_type_id",
        "contract_number",
        "contract_start",
        "contract_end",
        "type_of_car",
        "total_price"
    ];
    public function student()
    {
    return $this->belongsTo('App\Models\Student');
    }

    public function setContractStartAttribute($value)
    {
        $this->attributes['contract_start'] = Carbon::parse($value)->format('Y-m-d');
    }
    public function getContractStartAttribute()
    {
         return Carbon::parse($this->attributes['contract_start'])->format('Y-m-d');
    }

    public function setContractEndAttribute($value)
    {
        $this->attributes['contract_end'] = Carbon::parse($value)->format('Y-m-d');
    }
    public function getContractEndAttribute()
    {
         return Carbon::parse($this->attributes['contract_end'])->format('Y-m-d');
    }
}
