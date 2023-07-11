<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = "students";

    protected $fillable = ["name","email","password","city"];

    public $timestamps = false;

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
    public function student_course(){
        return $this->hasMany('App\Models\StudentCourse','student_id','id');
    }

    public function schedule(){
        return $this->hasMany('App\Models\Schedule','student_id','id');
    }
}
