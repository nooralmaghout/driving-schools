<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    protected $table = "students";

    protected $fillable = ["price","details","registration_end_date","registration_start_date","end_course","start_course","school_id"];

    public $timestamps = false;
    public function student_course(){
        return $this->hasMany('App\Models\StudentCourse','course_id','id');
    }
    public function schedule(){
        return $this->hasMany('App\Models\Schedule','course_id','id');
    }
    
}
