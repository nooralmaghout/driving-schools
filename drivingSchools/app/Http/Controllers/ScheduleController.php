<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\StudentInsurance;
use App\Models\Student;
use App\Models\InsuranceType;
use App\Models\InternationalLicense;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    //

    public function addInsuranceSchedule(Request $request,$id){
        // validation
        $request->validate([
            // "insurance_type_id" => "required",
            "date" => "required"
        ]);
        $time=Carbon::now();
        //validate date*******************
        if ($request->date>$time){
            $schedule = new Schedule();
            $schedule->insurance_type_id =$id;// $request->$insurance_type_id;
            $schedule->date = $request->date;
            $schedule->confirmation = false;
    
            $schedule->save();
    
            
    
            // send response
            return response()->json([
                "status" => 1,
                "message" => "Insurance offer created successfuly" 
            ]);
    
        }else{
            echo $time;
            return response()->json([
                "status" => 1,
                "message" => "invalid date entry" 
            ]);
        }

            }

    public function listInsuranceSchedule(){//for user
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
    
    public function listAllInsurances($id){//for the company
        //$id = auth()->user()->id;
        $ins = Schedule::with('insurance_type')->where('insurance_type_id',$id)->get();//

        return response()->json([
            "status" => 1,
            "message" => "Listing Insurance offers: ",
            "data" => $ins
        ],200);
    }

    public function listAllAvailableInsurances($id){//for the company
        //$id = auth()->user()->id;
        $ins = Schedule::with('insurance_type')->where('insurance_type_id',$id)->where('student_id',Null)->get();//

        return response()->json([
            "status" => 1,
            "message" => "Listing Insurance offers: ",
            "data" => $ins
        ],200);
    }
    public function listAllNotAvailableInsurances($id){//for the company
        //$id = auth()->user()->id;
        $ins = Schedule::with('insurance_type')->where('insurance_type_id',$id)->where('student_id',"!=",Null)->get();//

        return response()->json([
            "status" => 1,
            "message" => "Listing Insurance offers: ",
            "data" => $ins
        ],200);
    }

    public function deleteSchedule($id){
        if(Schedule::where("id", $id)->exists()){
            $ins = Schedule::find($id);
            try{
                $ins->delete();
            }catch(Throwable $th){
                return response()->json([
                    "status" => 0,
                    "message" => "can't delete this Schedule"
                    ],404); 
            }
            return response()->json([
                "status" => 1,
                "message" => "Schedule deleted successfully "
            ],200);
    
                
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Schedule not found"
                ],404);
        }
    
    }
    public function editSchedule(Request $request, $id){
        $request->validate([
            "date" => "required"
        ]);    
        if(Schedule::where("id", $id)->exists()){
           
            $ins = Schedule::find($id);
            $time=Carbon::now();
            //validate date*******************
            if ($request->date>$time){
            $ins->date = !empty($request->date)? $request->date : $ins->date;
            
            $ins->save();

            return response()->json([
                "status" => 1,
                "message" => "Schedule updated successfully "
            ],200);
        }else{
            echo $time;
            return response()->json([
                "status" => 1,
                "message" => "invalid date entry" 
            ]);
        }
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Schedule not found"
            ],404);
        }
        
        
    }

    public function confirmInsuranceSchedule(Request $request, $id){
        if(Schedule::where("id", $id)->exists()){
            $request->validate([
                // "insurance_type_id" => "required",
                "contract_number" => "required",
                "contract_end" => "required",
                "type_of_car" => "required",
                "total_price" => "required"
            ]);
            $ins = Schedule::find($id);
            $ins->confirmation = true;
            echo $ins->insurance_type_id;
            echo $ins->student_id;

            if(InsuranceType::where("id", $ins->insurance_type_id)->exists()
             && Student::where("id", $ins->student_id)->exists()){
                echo "true";
                $student_ins = new StudentInsurance();
                $student_ins->student_id =$ins->student_id;
                $student_ins->insurance_type_id = $ins->insurance_type_id;
                $student_ins->contract_number = $request->contract_number;
                $student_ins->contract_start = $ins->date;
                $student_ins->contract_end = $request->contract_end;
                $student_ins->type_of_car = $request->type_of_car;
                $student_ins->total_price = $request->total_price;
        
                $student_ins->save();
                $ins->save();
                return response()->json([
                    "status" => 1,
                    "message" => "Schedule confirmed" 
                ]);
            }else{
                return response()->json([
                    "status" => 0,
                    "message" => "Schedule not found"
                    ],404);
            }
            
           
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Schedule not found"
                ],404);
        }
    }


    ////////////////////international office
    public function addLicenseSchedule(Request $request){
        // validation
        $id = auth()->user()->id;
        $request->validate([
            "date" => "required"
        ]);
        $time=Carbon::now();
        //validate date*******************
        if ($request->date>$time){
            $schedule = new Schedule();
            $schedule->international_license_id = Null;//$license->id;
            $schedule->date = $request->date;
            $schedule->confirmation = false;
    
            $schedule->save();
            // send response
            return response()->json([
                "status" => 1,
                "message" => "international license created successfuly" 
            ]);
    
        }else{
            echo $time;
            return response()->json([
                "status" => 1,
                "message" => "invalid date entry" 
            ]);
        }

            }

        public function listLicenseSchedule(){//for user
                $offers = InternationalLicense::get();
                foreach($offers as $offer){
                    $international_office = InternationalOffice::where('id',$offer->international_office_id);
                    $offer->international_office_id = $international_office;
                }
                return response()->json([
                    "status" => 1,
                    "message" => "Listing Offers: ",
                    "data" => $offers
                ],200);
            }
            
        public function listAllLicenses(){//for the company
                //$id = auth()->user()->id;
                $ins = Schedule::where('insurance_type_id',Null)->where('course_id',Null)->get();//
        
                return response()->json([
                    "status" => 1,
                    "message" => "Listing international license offers: ",
                    "data" => $ins
                ],200);
            }
        
        public function listAllAvailableLicenses(){//for the company
                //$id = auth()->user()->id;
                $ins = Schedule::where('insurance_type_id',Null)->where('course_id',Null)
                ->where('student_id',Null)->get();//
        
                return response()->json([
                    "status" => 1,
                    "message" => "Listing international license offers: ",
                    "data" => $ins
                ],200);
            }
        public function listAllNotAvailableLicenses(){//for the company
                //$id = auth()->user()->id;
                $ins = Schedule::where('insurance_type_id',Null)->where('course_id',Null)
                ->where('international_license_id',Null)
                ->where('student_id',"!=",Null)->get();//
        
                return response()->json([
                    "status" => 1,
                    "message" => "Listing international license offers: ",
                    "data" => $ins
                ],200);
            }

        public function confirmLicenseSchedule(Request $request, $id){
                if(Schedule::where("id", $id)->exists()){
                    $office = auth()->user()->id;
                    $request->validate([
                        // "insurance_type_id" => "required",
                        "date_of_expiring" => "required",
                    ]);
                    $ins = Schedule::find($id);
                    $ins->confirmation = true;
                    echo $ins->student_id;
        
                    
                    $student_license = new InternationalLicense();
                    $student_license->student_id =$ins->student_id;
                    $student_license->international_office_id =$office;
                    $student_license->date_of_granting = Carbon::now();
                    $student_license->date_of_expiring = $request->date_of_expiring;
                        
                    $student_license->save();
                    $ins->save();
                        return response()->json([
                            "status" => 1,
                            "message" => "Schedule confirmed" 
                        ]);
                    }else{
                        return response()->json([
                            "status" => 0,
                            "message" => "Schedule not found"
                            ],404);
                    }
                
            }
//////////////////user
    public function schedule($id){
        $user_id = auth()->user()->id;
        $schedule = Schedule::find($id);
        // if($schedule->course_id != Null){
        //     $s =5;
        // }elseif($schedule->insurance_type_id != Null){
        //     $s =Schedule::where($schedule->insurance_type_id,"!=",Null)
        //     ->where($schedule->student_id,$user_id)
        //     ->where($schedule->confirmation,false);
        // }else{
        //     $s =5;
        // }
         
        if($schedule->Student_id == Null){
            $schedule->Student_id = $user_id;
            $schedule->save();
            return response()->json([
                "status" => 1,
                "message" => "schedule succeded" 
            ]);
        }
        else{
            return response()->json([
                "status" => 1,
                "message" => "schedule not available" 
            ]);
        }
        

    }




}
