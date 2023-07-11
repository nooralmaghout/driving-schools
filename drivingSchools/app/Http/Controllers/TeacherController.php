<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function createTeacher(Request $request){
        // validation
    
        $request->validate([
            "name" => "required",
            "age" => "required",
            "years_of_experience" => "required",
            "gender" => "required",
        ]);

        // create data
        $teacher = new Teacher();

        $teacher->name = $request->name;
        $teacher->age = $request->age;
        $teacher->years_of_experience = $request->years_of_experience;
        $teacher->gender = $request->gender;

        $teacher->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Teacher added successfuly" 
        ]);
    }
}
