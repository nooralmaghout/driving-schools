<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternationalOffice;

class InternationalOfficeController extends Controller
{
    //
    public function createInternationalOfficeAccount(Request $request){
        // validation
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required|confirmed",
            "details"  => "required",
            "city" => "required",
            "location" => "required",
            "price" => "required"
        ]);

        // create data
        $internationalOffice = new InternationalOffice();

        $internationalOffice->name = $request->name;
        $internationalOffice->email = $request->email;
        $internationalOffice->password = $request->password;
        $internationalOffice->details = $request->details;
        $internationalOffice->city = $request->city;
        $internationalOffice->price = $request->price;
        $internationalOffice->location = $request->location;

        $internationalOffice->save();

        

        // send response
        return response()->json([
            "status" => 1,
            "message" => "International Office account created successfuly" 
        ]);
    }

    public function login(Request $request){
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);
        //check

        $internationalOffice = InternationalOffice::where("email", "=" , $request->email)->first();
        if(isset($internationalOffice->id)){
            if($request->password == $internationalOffice->password){

                //create token
                $token = $internationalOffice->createToken("auth_token")->plainTextToken;
                //send response
                return response()->json([
                    "status" => 1,
                    "message" => "International Office logged in successfully",
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
                "message" => "International Office not found"
            ],404);
        }
        
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([

            "status"=>1,
            "message"=>"International Office logged out successfully"

        ]);
    }
    public function listInternationalOffices(){
        $ins = InternationalOffice::get();

        return response()->json([
            "status" => 1,
            "message" => "Listing International Offices: ",
            "data" => $ins
        ],200);
    }

    public function getSingleInternationalOffice($id){
        if(InternationalOffice::where("id", $id)->exists()){
            $ins_details = InternationalOffice::where("id", $id)->first();
           
            return response()->json([
                "status" => 1,
                "message" => "International Office found ",
                "data" => $ins_details
            ],200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "International Office not found"
            ],404);
        }
    }
    
    public function deleteInternationalOffice($id){
        if(InternationalOffice::where("id", $id)->exists()){
            $ins = InternationalOffice::find($id);
            try{
                $ins->delete();
            }catch(Throwable $th){
                return response()->json([
                    "status" => 0,
                    "message" => "can't delete this International Office"
                    ],404); 
            }
            return response()->json([
                "status" => 1,
                "message" => "International Office deleted successfully "
            ],200);
    
                
        }else{
            return response()->json([
                "status" => 0,
                "message" => "International Office not found"
                ],404);
        }
    
    }

    public function profile(){
        $user_id = auth()->user()->id;
    
        if(InternationalOffice::where([
            "id" => $user_id,
        ] )->exists()){
        return response()->json([
    
            "status"=>1,
            "message"=>"International Office profile information ",
            "data" => auth()->user()
          ]);
        }
    }

    public function editeProfile(Request $request){
        $id = auth()->user()->id;

        $request->validate([
            "price" => "nullable",
            "details" => "nullable"
        ]);    
        if(InternationalOffice::where("id", $id)->exists()){
           
            $ins = InternationalOffice::find($id);
            
            $ins->price = !empty($request->price)? $request->price : $ins->price;
            $ins->details = !empty($request->details)? $request->details : $ins->details;
            
            $ins->save();

            return response()->json([
                "status" => 1,
                "message" => "International Office updated successfully "
            ],200);
        
        }else{
            return response()->json([
                "status" => 0,
                "message" => "International Office not found"
            ],404);
        }
        
        
    }

}
