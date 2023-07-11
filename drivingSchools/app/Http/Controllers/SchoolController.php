<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{
    //
    public function createSchoolAccount(Request $request){
        // validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:schools",
            "password" => "required|confirmed",
            "about"  => "required",
            "city" => "required",
            "location" => "required",
        ]);

        // create data
        $school = new School();

        $school->name = $request->name;
        $school->email = $request->email;
        $school->password = $request->password;
        $school->about = $request->about;
        $school->city = $request->city;
        $school->location = $request->location;

        $school->save();

       
        // send response
        return response()->json([
            "status" => 1,
            "message" => "School account created successfuly" 
        ]);
    }

    public function login(Request $request){
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);
        //check

        $school = School::where("email", "=" , $request->email)->first();
        if(isset($school->id)){
            if($request->password == $school->password){

                //create token
                $token = $school->createToken("auth_token")->plainTextToken;
                //send response
                return response()->json([
                    "status" => 1,
                    "message" => "School logged in successfully",
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
                "message" => "School not found"
            ],404);
        }
        
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([

            "status"=>1,
            "message"=>"School logged out successfully"

        ]);
    }
    public function listSchools(){
        $schools = School::get();

        return response()->json([
            "status" => 1,
            "message" => "Listing Schools: ",
            "data" => $schools
        ],200);
    }

    public function getSingleSchool($id){
        if(School::where("id", $id)->exists()){
            $school_details = School::where("id", $id)->first();
           
            return response()->json([
                "status" => 1,
                "message" => "School found ",
                "data" => $school_details
            ],200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "School not found"
            ],404);
        }
    }
    
    public function deleteSchool($id){
        if(School::where("id", $id)->exists()){
            $school = School::find($id);
            try{
                $school->delete();
            }catch(Throwable $th){
                return response()->json([
                    "status" => 0,
                    "message" => "can't delete this School"
                    ],404); 
            }
            return response()->json([
                "status" => 1,
                "message" => "School deleted successfully "
            ],200);
    
                
        }else{
            return response()->json([
                "status" => 0,
                "message" => "School not found"
                ],404);
        }
    
    }
}
