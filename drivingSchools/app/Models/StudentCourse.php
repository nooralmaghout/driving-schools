<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class StudentCourse extends Model
{
    use HasFactory;
    protected $table = "student_courses";

    protected $fillable = ["student_id","course_id"];

    public $timestamps = false;
    public function student()
    {
    return $this->belongsTo('App\Models\Student');
    }

    public function course()
    {
    return $this->belongsTo('App\Models\Course');
    }

   
}
