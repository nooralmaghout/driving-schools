<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    //
    public function register(Request $request){
        // validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:admins",
            "password" => "required|confirmed"
        ]);

        // create data
        $admin = new Admin();

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = $request->password;

        $admin->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Admin created successfuly" 
        ]);
    }

    public function login(Request $request){
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);
        //check

        $admin = Admin::where("email", "=" , $request->email)->first();
        if(isset($admin->id)){
            if($request->password == $admin->password){

                //create token
                $token = $admin->createToken("auth_token")->plainTextToken;
                //send response
                return response()->json([
                    "status" => 1,
                    "message" => "Admin logged in successfully",
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
                "message" => "Admin not found"
            ],404);
        }
        
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([

            "status"=>1,
            "message"=>"Admin logged out successfully"

        ]);
    }
}
