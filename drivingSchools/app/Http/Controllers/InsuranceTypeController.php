<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsuranceCompany;
use App\Models\InsuranceType;


class InsuranceTypeController extends Controller
{
    //
    public function createInsuranceType(Request $request){
        // validation
        $request->validate([
            "type_of_insurance" => "required",
            "price_of_type" => "required",
            "price_of_car" => "required",
            "offer" => "required"
            
        ]);

        // create data
        $ins_type = new InsuranceType();
        $id = auth()->user()->id;
        $ins_type->insurance_company_id = $id;
        $ins_type->type_of_insurance = $request->type_of_insurance;
        $ins_type->price_of_type = $request->price_of_type;
        $ins_type->price_of_car = $request->price_of_car;
        $ins_type->offer = $request->offer;

        $ins_type->save();

        

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Insurance offer created successfuly" 
        ]);
    }

    public function listInsurances(){
        $offers = InsuranceType::get();
        foreach($offers as $offer){
            $insurance_company = InsuranceCompany::where('id',$offer->insurance_company_id);
            $offer->insurance_company_id = $insurance_company;
        }
        return response()->json([
            "status" => 1,
            "message" => "Listing Offers: ",
            "data" => $offers
        ],200);
    }
    
    public function listCompaniesInsurances(){
        $id = auth()->user()->id;
        $ins = InsuranceType::with('insurance_company')->where('insurance_company_id',$id)->get();//

        return response()->json([
            "status" => 1,
            "message" => "Listing Insurance offers: ",
            "data" => $ins
        ],200);
    }

    public function deleteInsuranceOffer($id){
        //$insurance_company_id = auth()->user()->id;
        // $ins = InsuranceType::where('id',$id)->get();
        if(InsuranceType::where("id", $id)->exists()){
            $ins = InsuranceType::find($id);
            try{
                $ins->delete();
            }catch(Throwable $th){
                return response()->json([
                    "status" => 0,
                    "message" => "can't delete this offer"
                    ],404); 
            }
            return response()->json([
                "status" => 1,
                "message" => "Offer deleted successfully "
            ],200);
    
                
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Offer not found"
                ],404);
        }
    
    }
    public function editInsuranceOffer(Request $request, $id){
        $request->validate([
            "type_of_insurance" => "nullable",
            "price_of_type" => "nullable",
            "price_of_car" => "nullable",
            "offer" => "nullable"
            
        ]);    
        if(InsuranceType::where("id", $id)->exists()){
           
            $ins = InsuranceType::find($id);

            $ins->type_of_insurance = !empty($request->type_of_insurance)? $request->type_of_insurance : $ins->type_of_insurance;
            $ins->price_of_type = !empty($request->price_of_type)? $request->price_of_type : $ins->price_of_type;
            $ins->price_of_car = !empty($request->price_of_car)? $request->price_of_car : $ins->price_of_car;
            $ins->price_of_car = !empty($request->price_of_car)? $request->price_of_car : $ins->price_of_car;
            $ins->offer = !empty($request->offer)? $request->offer : $ins->offer;
            $ins->save();

            return response()->json([
                "status" => 1,
                "message" => "Offer updated successfully "
            ],200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Offer not found"
            ],404);
        }
        
        
    }
}
