<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\Answers\UpdateAnswerRequest;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        $question->answers()->create([
            'body'=>$request->body,
            'user_id'=>auth()->id()
        ]);
        session()->flash('success', 'Your answer submitted succesfully!');
        return redirect($question->url);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update',$answer);
        
        return view('answers.edit',compact([
            'question',
            'answer'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnswerRequest $request,Question $question, Answer $answer)
    {
        
        $answer->update([
            'body'=>$request->body
        ]);
        session()->flash('success', 'Your answer updated succesfully!');
        return redirect($question->url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question,Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        session()->flash('success', 'Your answer deleted succesfully!');
        return redirect($question->url);
    }

    
    public function bestAnswer(Request $request, Answer $answer){
        $this->authorize('markAsBest', $answer);
        $answer->question->markBestAnswer($answer);
        return redirect()->back();
    }
}
