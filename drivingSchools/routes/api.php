<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\InsuranceCompanyController;
use App\Http\Controllers\InsuranceTypeController;
use App\Http\Controllers\InternationalOfficeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\ScheduleController;
// use App\Http\Controllers\InternationalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/********Admin Apis********/
Route::post("registerAdmin", [AdminController::class, "register"]);
Route::post("loginAdmin", [AdminController::class, "login"]);
Route::group(["middleware" => ["auth:sanctum"]], function(){
    Route::get("logoutAdmin", [AdminController::class, "logout"]);
    //create Accounts
    Route::post("createInsuranceCompanyAccount", [InsuranceCompanyController::class, "createInsuranceCompanyAccount"]);
    Route::post("createInternationalOfficeAccount", [InternationalOfficeController::class, "createInternationalOfficeAccount"]);
    Route::post("createSchoolAccount", [SchoolController::class, "createSchoolAccount"]);
    
    Route::get("listInsuranceCompanies", [InsuranceCompanyController::class, "listInsuranceCompanies"]);
    Route::get("getSingleInsuranceCompany/{id}", [InsuranceCompanyController::class, "getSingleInsuranceCompany"]);
    Route::delete("deleteInsuranceCompany/{id}", [InsuranceCompanyController::class, "deleteInsuranceCompany"]);
    
    Route::get("listSchools", [SchoolController::class, "listSchools"]);
    Route::get("getSingleSchool/{id}", [SchoolController::class, "getSingleSchool"]);
    Route::delete("deleteSchool/{id}", [SchoolController::class, "deleteSchool"]);
    
    Route::get("listInternationalOffices", [InternationalOfficeController::class, "listInternationalOffices"]);
    Route::get("getSingleInternationalOffice/{id}", [InternationalOfficeController::class, "getSingleInternationalOffice"]);
    Route::delete("deleteInternationalOffice/{id}", [InternationalOfficeController::class, "deleteInternationalOffice"]);


    ////create test
    Route::post("createTest", [TestController::class, "createTest"]);
    Route::post("createTest2", [TestController::class, "createTest2"]);
    Route::post("createQuestion", [QuestionController::class, "createQuestion"]);
    //get test
    Route::get("listQuestions", [QuestionController::class, "listQuestions"]);
    Route::get("getSingleQuestion/{id}", [QuestionController::class, "getSingleQuestion"]);
    Route::get("listTests", [TestController::class, "listTests"]);
    Route::get("getSingleTest/{id}", [TestController::class, "getSingleTest"]);

    Route::delete("deleteQuestion/{id}", [QuestionController::class, "deleteQuestion"]);
    Route::delete("deleteTest/{id}", [TestController::class, "deleteTest"]);

});

/********Student Apis********/
Route::post("registerStudent", [StudentController::class, "createStudentAccount"]);
Route::post("loginStudent", [StudentController::class, "login"]);
Route::get("getTest", [QuestionController::class, "getTest"]);
Route::get("answer question/{id}/{answer}", [QuestionController::class, "answerQuestion"]);
Route::post("test result", [QuestionController::class, "answerQuestions"]);
Route::get("viewSchools", [SchoolController::class, "listSchools"]);
/////////////////InternationalLicense
Route::get("viewInternationalLicenseDetails", [InternationalOfficeController::class, "listInternationalOffices"]);
Route::get("getSingleInternationalOffice/{id}", [InternationalOfficeController::class, "getSingleInternationalOffice"]);
Route::get("listAllavLicenseSchedules", [ScheduleController::class, "listAllAvailableLicenses"]);


/////////////////Insurance
Route::get("getSingleInsurance/{id}", [InsuranceTypeController::class, "getSingleInsurance"]);
Route::get("listAllavInsuranceSchedules/{id}", [ScheduleController::class, "listAllAvailableInsurancesforuser"]);

Route::get("viewInsuranceOffers", [InsuranceTypeController::class, "listInsurances"]);
Route::get("viewInsuranceOffersByType/{type}", [InsuranceTypeController::class, "getByTypeInsurance"]);

Route::group(["middleware" => ["auth:sanctum"]], function(){
    Route::get("logoutStudent", [StudentController::class, "logout"]);
    Route::get("listStudentCourses", [StudentCourseController::class, "listStudentCourses"]);
    Route::get("scheduleLicense/{id}", [ScheduleController::class, "scheduleLicense"]);
    Route::get("scheduleInsurance/{id}", [ScheduleController::class, "scheduleInsurance"]);
    Route::get("viewMyInsuranceOffers", [ScheduleController::class, "viewMyInsuranceOffers"]);
    Route::get("viewMyLicenses", [ScheduleController::class, "viewMyLicensesOffers"]);



});


/********Insurance Apis********/
Route::post("loginInsurance", [InsuranceCompanyController::class, "login"]);
Route::group(["middleware" => ["auth:sanctum"]], function(){
    Route::get("logoutInsurance", [InsuranceCompanyController::class, "logout"]);
    Route::post("createInsuranceOffer", [InsuranceTypeController::class, "createInsuranceType"]);
    Route::get("listCompany'sInsurances", [InsuranceTypeController::class, "listCompaniesInsurances"]);
    Route::put("editInsuranceOffer/{id}", [InsuranceTypeController::class, "editInsuranceOffer"]);
    Route::delete("deleteCompany'sInsurance/{id}", [InsuranceTypeController::class, "deleteInsuranceOffer"]);
    
    Route::post("createInsuranceSchedule/{id}", [ScheduleController::class, "addInsuranceSchedule"]);
    Route::get("listCompany'sInsuranceSchedules/{id}", [ScheduleController::class, "listAllInsurances"]);
    Route::get("listAvailableInsuranceSchedules/{id}", [ScheduleController::class, "listAllAvailableInsurances"]);
    Route::get("listNonAvailableInsuranceSchedules/{id}", [ScheduleController::class, "listAllNotAvailableInsurances"]);
    Route::put("editInsuranceOfferSchedule/{id}", [ScheduleController::class, "editSchedule"]);
    Route::delete("deleteCompany'sInsuranceSchedule/{id}", [ScheduleController::class, "deleteSchedule"]);

    Route::put("confirmInsuranceSchedule/{id}", [ScheduleController::class, "confirmInsuranceSchedule"]);

});

/********International office Apis********/
Route::post("loginInternationalOffice", [InternationalOfficeController::class, "login"]);
Route::group(["middleware" => ["auth:sanctum"]], function(){
    Route::get("logoutInternationalOffice", [InternationalOfficeController::class, "logout"]);
    Route::put("editDetails", [InternationalOfficeController::class, "editeProfile"]);
    Route::get("profileInternationalOffice", [InternationalOfficeController::class, "profile"]);

    Route::post("addLicenseSchedule", [ScheduleController::class, "addLicenseSchedule"]);
    Route::get("listLicenseSchedules", [ScheduleController::class, "listAllLicenses"]);
    Route::get("listAvailableLicenseSchedules", [ScheduleController::class, "listAllAvailableLicenses"]);
    Route::get("listNonAvailableLicenseSchedules", [ScheduleController::class, "listAllNotAvailableLicenses"]);
    Route::put("editLicenseSchedule/{id}", [ScheduleController::class, "editSchedule"]);
    Route::delete("deleteLicenseSchedule/{id}", [ScheduleController::class, "deleteSchedule"]);

    Route::put("confirmLicenseSchedule/{id}", [ScheduleController::class, "confirmLicenseSchedule"]);


});