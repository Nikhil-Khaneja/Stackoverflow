<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Notifications\VoteAnswerNotification;
use App\Notifications\VoteQuestionNotification;
use App\Question;
use app\User;
use Illuminate\Http\Request;

class VotesController extends Controller
{
   public function voteQuestion(Question $question, int $vote)
    {
        //Either I need to update the vote or need to create the vote
        if(auth()->user()->hasVoteForQuestion($question)) {
            $question->updateVote($vote);
            $question->owner->notify(new VoteQuestionNotification($question, "Your Question has been DownVoted"));
        }else {
            $question->vote($vote);
            $question->owner->notify(new VoteQuestionNotification($question, "Your Question has been UpVoted"));
        }
        return redirect()->back();
    }

    public function voteAnswer(Answer $answer, int $vote)
    {
        //Either I need to update the vote or need to create the vote
        if(auth()->user()->hasVoteForAnswer($answer)) {
            $answer->updateVote($vote);
            $answer->author->notify(new VoteAnswerNotification($answer, "Your Question has been DownVoted"));

        }else {
            $answer->vote($vote);
            $answer->author->notify(new VoteAnswerNotification($answer, "Your Question has been DownVoted"));
        }
        return redirect()->back();
    }
}
