<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsuranceCompany;

class InsuranceCompanyController extends Controller
{
    //
    public function createInsuranceCompanyAccount(Request $request){
        // validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:insurance_companies",
            "password" => "required|confirmed",
            "about"  => "required",
            "city" => "required",
            "location" => "required",
        ]);

        // create data
        $ins_company = new InsuranceCompany();

        $ins_company->name = $request->name;
        $ins_company->email = $request->email;
        $ins_company->password = $request->password;
        $ins_company->about = $request->about;
        $ins_company->city = $request->city;
        $ins_company->location = $request->location;

        $ins_company->save();

        

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Insurance Company account created successfuly" 
        ]);
    }

    public function login(Request $request){
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);
        //check

        $ins_company = InsuranceCompany::where("email", "=" , $request->email)->first();
        if(isset($ins_company->id)){
            if($request->password == $ins_company->password){

                //create token
                $token = $ins_company->createToken("auth_token")->plainTextToken;
                //send response
                return response()->json([
                    "status" => 1,
                    "message" => "Insurance Company logged in successfully",
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
                "message" => "Insurance Company not found"
            ],404);
        }
        
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([

            "status"=>1,
            "message"=>"Insurance Company logged out successfully"

        ]);
    }

    public function listInsuranceCompanies(){
        $ins = InsuranceCompany::get();

        return response()->json([
            "status" => 1,
            "message" => "Listing InsuranceCompanies: ",
            "data" => $ins
        ],200);
    }

    public function getSingleInsuranceCompany($id){
        if(InsuranceCompany::where("id", $id)->exists()){
            $ins_details = InsuranceCompany::where("id", $id)->first();
           
            return response()->json([
                "status" => 1,
                "message" => "Insurance Company found ",
                "data" => $ins_details
            ],200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Insurance Company not found"
            ],404);
        }
    }
    
    public function deleteInsuranceCompany($id){
        if(InsuranceCompany::where("id", $id)->exists()){
            $ins = InsuranceCompany::find($id);
            try{
                $ins->delete();
            }catch(Throwable $th){
                return response()->json([
                    "status" => 0,
                    "message" => "can't delete this Insurance Company"
                    ],404); 
            }
            return response()->json([
                "status" => 1,
                "message" => "Insurance Company deleted successfully "
            ],200);
    
                
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Insurance Company not found"
                ],404);
        }
    
    }
}
