<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;


class Schedule extends Model
{
    use HasFactory;

    protected $table = "schedules";

    protected $fillable = ["student_id","international_license_id","course_id","insurance_type_id","date","confirmation"];

    public $timestamps = false;
    public function student()
    {
    return $this->belongsTo('App\Models\Student');
    }
    public function international_license()
    {
    return $this->belongsTo('App\Models\InternationalLicense');
    }
    public function course()
    {
    return $this->belongsTo('App\Models\Course');
    }
    public function insurance_type()
    {
    return $this->belongsTo('App\Models\InsuranceType');
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d H:i');
    }
    public function getDateAttribute()
    {
         return Carbon::parse($this->attributes['date'])->format('Y-m-d H:i');
    }
}
