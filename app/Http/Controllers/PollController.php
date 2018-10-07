<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Models\Poll;
use App\Http\Models\PollQuestions;
use App\Http\Models\PollAnswer;
use App\Http\Models\Voted;

class PollController extends Controller
{
    //
    public function __construct()
    {
        $this->poll = new Poll();
        $this->poll_questions = new PollQuestions();
        $this->poll_answer = new PollAnswer();
        $this->voted = new Voted();
    }

    public function GettPoll()
    {
        $output = $this->poll
            ->with('PollQuestion.PollAnswer')
            ->where('state', '=', '1')
            ->get();
        return Response()->json(['get_poll'=>$output]);
    }

    public function StoreVoted()
    {
        $input = Request()->all();
        for ($i = 0; $i < count($input); $i++) {
            $this->voted->create($input[$i]);
        }

        return ['state' => '202'];

    }

}
