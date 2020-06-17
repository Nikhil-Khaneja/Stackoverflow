<?php

namespace App\Http\Controllers;

use App\Http\Requests\Questions\CreateQuestionRequest;
use App\Http\Requests\Questions\UpdateQuestionRequest;
use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
   
    public function ___construct(){
        $this->middleware(['auth'])->only(['create','store']);
    }
    public function index()
    {
        $questions = Question::with('owner')
            ->latest()
            ->paginate(10); //eager load is with() functio this will fasten your loading
        
        return view('questions.index', compact([ 
            'questions'
            ]));
    }

    
    public function create()
    {
        // app('debugbar')->disable();
        return view('questions.create');
    }

   
    public function store(CreateQuestionRequest $request)
    {
        auth()->user()->questions()->create([
            'title'=>$request->title,
            'body'=>$request->body
        ]);

        session()->flash('success', 'Question has been added SuccessFully !');
        return redirect(route('questions.index'));
    }

    
    public function show(Question $question)
    {
        //
    }

    public function edit(Question $question)
    {
         // app('debugbar')->disable();
         return view('questions.edit', compact([
             'question'
         ]));
    }

    
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update([
            'title'=>$request->title,
            'body'=>$request->body
        ]);
        session()->flash('success', 'Question has been updated SuccessFully !');
        return redirect(route('questions.index'));
    }

    
    public function destroy(Question $question)
    {
        $question->delete();
        session()->flash('success','Question has been added deleted Successfully!');
        return redirect(route('questions.index'));
    }
}
