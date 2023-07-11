<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    //
    public function createQuestion(Request $request){
        $request->validate([
            "question" => "required",
            "answer" => "required",
            "choice1" => "required",
            "choice2" => "required",
            "choice3" => "required",
            "mark" => "required",
        ]);

        // create data
        $question = new Question();

        $question->question = $request->question;
        $question->answer = $request->answer;
        $question->choice1 = $request->choice1;
        $question->choice2 = $request->choice2;
        $question->choice3 = $request->choice3;
        $question->mark = $request->mark;


        $question->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "question created successfuly" 
        ]);
    }

    public function listQuestions(){
        $questions = Question::get();

        return response()->json([
            "status" => 1,
            "message" => "Listing Questions: ",
            "data" => $questions
        ],200);
    }

    public function getSingleQuestion($id){
        if(Question::where("id", $id)->exists()){
           
            $question_details = Question::where("id", $id)->first();
            return response()->json([
                "status" => 1,
                "message" => "Question found ",
                "data" => $question_details
            ],200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Question not found"
            ],404);
        }
    }
    public function deleteQuestion($id){
        if(Question::where("id", $id)->exists()){
           
            $question = Question::find($id);

            $question->delete();

            return response()->json([
                "status" => 1,
                "message" => "Question deleted successfully "
            ],200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Question not found"
            ],404);
        }
    
    }

    public function getTest(){
        $questions = Question::all('id','question','choice1','choice2','choice3')->random(5);

        return response()->json([
            "status" => 1,
            "message" => "here is your test: ",
            "data" => $questions
        ],200);
    }
    public function answerQuestion($id, $answer){
        
        $question = Question::where('id',$id)->first();
        if($answer == $question->answer){
            return response()->json([
                "status" => 1,
                "message" => "correct answer :)",
            ],200);
        }
        else return response()->json([
            "status" => 1,
            "message" => "not correct answer!"
        ],200);

        
    }
    public function answerQuestions(Request $request){
        $request->validate([
            "questions" => "required",
            "answers" => "required",
        ]);
        $questions = $request->questions;
        $answers = $request->answers;
        $marks = 0;
       foreach($questions as $key => $value){
            echo $key;
            echo $value['id'];
            echo $answers[$key];
              if($answers[$key] == $value['answer']) {
                echo "true";
                $marks += $value['mark'];
                }
       }
            return response()->json([
                "status" => 1,
                "message" => "your result",
                "data" => $marks
            ],200);
        
    }

}
