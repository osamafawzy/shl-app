<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Models\Poll;
use App\Http\Models\PollAnswer;
use App\Http\Models\PollQuestions;
use App\Http\Models\Voted;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class questionnaireAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->PollsQuestions = new PollQuestions();
        $this->PollAnswers = new PollAnswer();
        $this->Votes = new Voted();
        $this->Polls = new Poll();

    }
    public function addquestionnaireindex($id=null){
        $id=$id;
        return view('questionnaire.addQuestion',compact('id'));
    }

    public function StoreQuestions($id = null){
        $input = Request()->all();

        if ($id !=""){
            $poll=Poll::find($id);
        }else{
            $poll = new Poll();
            $poll->state=1;
            $poll->save();
        }

        $input['poll_id'] = $poll['poll_id'];
        $output1 = $this->PollsQuestions->create($input);
        $input['poll_question_id'] = $output1->poll_questions_id;

        $input['answer_ar'] = $input['answer_ar1'];
        $input['answer_en'] = $input['answer_en1'];
        $input['answer_ur'] = $input['answer_ur1'];
        $this->PollAnswers->create($input);

        $input['answer_ar'] = $input['answer_ar2'];
        $input['answer_en'] = $input['answer_en2'];
        $input['answer_ur'] = $input['answer_ur2'];
        $this->PollAnswers->create($input);

        $input['answer_ar'] = $input['answer_ar3'];
        $input['answer_en'] = $input['answer_en3'];
        $input['answer_ur'] = $input['answer_ur3'];
        $this->PollAnswers->create($input);


        for ($i = 0; $i < count($input['other_question']); $i++) {
            $input['question_ar'] = $input['other_question'][$i]['questions_ar'];
            $input['question_en'] = $input['other_question'][$i]['questions_en'];
            $input['question_ur'] = $input['other_question'][$i]['questions_ur'];
            $output4 =$this->PollsQuestions->create($input);
            $input['poll_question_id'] = $output4->poll_questions_id;

            $input['answer_ar'] = $input['other_question'][$i]['answers_ar1'];
            $input['answer_en'] = $input['other_question'][$i]['answers_en1'];
            $input['answer_ur'] = $input['other_question'][$i]['answers_ur1'];
            $this->PollAnswers->create($input);

            $input['answer_ar'] = $input['other_question'][$i]['answers_ar2'];
            $input['answer_en'] = $input['other_question'][$i]['answers_en2'];
            $input['answer_ur'] = $input['other_question'][$i]['answers_ur2'];
            $this->PollAnswers->create($input);

            $input['answer_ar'] = $input['other_question'][$i]['answers_ar3'];
            $input['answer_en'] = $input['other_question'][$i]['answers_en3'];
            $input['answer_ur'] = $input['other_question'][$i]['answers_ur3'];
            $this->PollAnswers->create($input);
        }

    }

    public function GetQuestionsPage($id = null){
        $id = $id;
        return view('questionnaire.Questions',compact('id'));
    }

    public function AllQuestions($id){
        $output= $this->PollsQuestions->where('poll_id',$id)->with('PollAnswer')->get();
//        dd($output);
        return $output;
    }

    public function RecieveQuestionnaire(Request $request,$id){

        $poll = Poll::find($id);
        foreach ($request->toArray() as $key => $req){
            if (!empty($req)){
                $Votes = new Voted();
                $Votes->poll_question_id=$key;
                $Votes->poll_answer_id=$req;
                $Votes->poll_id=$poll->poll_id;
                $Votes->save();
            }
        }



    }

    public function pollindex(){
        return view('questionnaire.polls');
    }

    public function GetPolls(){
        $output = $this->Polls->where('state','1')->get();
        return $output;
    }

    public function profilepage($id){

    }

    public function DeletePoll($id){
        $poll = Poll::find($id);
        foreach ($poll->PollQuestion as $question) {
            foreach ($question->PollAnswer as $answer){
                $answer->delete();
            }
            $question->delete();
        }
//        PollAnswer::where('poll_questions_id',$output->poll_questions_id);
        $poll->delete();

        $votes = Voted::where('poll_id',$id);
        foreach ($votes as $vote){
            $vote->delete();
        }
    }

    public function deletequestion($id){
        $votes = Voted::where('poll_question_id',$id)->get();
        foreach ($votes as $vote){
            $vote->delete();
        }


        $output = PollQuestions::find($id);
        foreach ($output->PollAnswer as $answer){
            $answer->delete();
        }
        $output->delete();
    }

    public function showresult($id){
//        $voted = Voted::where('poll_id',$id)->get();
//        foreach ($voted as $vote){
//           $output = PollAnswer::where('poll_question_id',$vote->poll_question_id)->get();
//           $voted->groupBy($output);
//        }

        $selected=[];

        $output = DB::table('voted')
            ->where('poll_id',$id)
            ->select(DB::raw('poll_question_id,poll_answer_id,count(*) as count'))
            ->groupBy(['poll_question_id','poll_answer_id'])
            ->get();

//         $output =  $voted->groupBy(['poll_question_id','poll_answer_id']);



        foreach ($output as $key => $out){
            $ques = PollQuestions::where('poll_questions_id',$out->poll_question_id)->first();
            $ans = PollAnswer::where('poll_answer_id',$out->poll_answer_id)->first();
            $count = $out->count;
            $selected[$key]=[
                'question'=>$ques,
                'answer'=>$ans,
                'count'=>$count
            ];
        }


        return $selected ;
    }

}
