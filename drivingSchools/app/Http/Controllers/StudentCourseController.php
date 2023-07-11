<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentCourse;


class StudentCourseController extends Controller
{
    //
    public function listStudentCourses(){
        $user = auth()->user()->id;
        $courses = StudentCourse::with('student','course');

        return response()->json([
            "status" => 1,
            "message" => "Listing Student Courses: ",
            "data" => $courses
        ],200);
    }
}
