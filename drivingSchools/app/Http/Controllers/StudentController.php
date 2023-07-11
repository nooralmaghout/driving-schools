<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    //
    public function createStudentAccount(Request $request){
        // validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:students",
            "password" => "required|confirmed",
            "city" =>  "required",
            "age" =>  "required",
        ]);
        if( $request->age<18){
            return response()->json([
                "status" => 1,
                "message" => "Sorry you can't create account!" 
            ]);
        }
        // create data
        $student = new Student();

        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = $request->password;
        $student->city = $request->city;
        $student->age = $request->age;
        
        $student->save();

       

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Student account created successfuly" 
        ]);
    }

    public function login(Request $request){
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);
        //check

        $student = Student::where("email", "=" , $request->email)->first();
        if(isset($student->id)){
            if($request->password == $student->password){

                //create token
                $token = $student->createToken("auth_token")->plainTextToken;
                //send response
                return response()->json([
                    "status" => 1,
                    "message" => "Student logged in successfully",
                    "access_token"=> $token
                    ]);
            }else{
            return response()->json([
                "status" => 0,
                "message" => "Password is not correct"
            ],404);
        }
        
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Student not found"
            ],404);
        }
        
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([

            "status"=>1,
            "message"=>"Student logged out successfully"

        ]);
    }

    
}
