<?php

namespace App\Http\Controllers;

use App\Http\Requests\Questions\CreateQuestionRequest;
use App\Http\Requests\Questions\UpdateQuestionRequest;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuestionsController extends Controller
{
   
    public function ___construct(){
        $this->middleware(['auth'])->only(['create','store','edit','update']);
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

    // METHOD 1    
    // public function show($slug)
    // {
    //     $question = Question::where('slug', $slug)->firstOrFail();
    // }

    // METHOD 2
    public function show(Question $question){
        $question->increment('views_count');//this method will increment the count of var899
        return view('questions.show', compact([
            'question'
        ]));
    }

    public function edit(Question $question)
    {
         // app('debugbar')->disable();
         //if(Gate::allows('update-question', $question)){
        if($this->authorize('update', $question)){ 
            return view('questions.edit', compact([
                'question'
            ]));
        }
         abort(403);
    }

    
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        //method 1 for calling gate
        //if(Gate::allows('update-question', $question)){
            //jaise hi policy banaunga toh authorize method aa jaayega controller ke pass jo meko batayega ki kisko call karna hai 
        if($this->authorize('update', $question)){
            $question->update([
                'title'=>$request->title,
                'body'=>$request->body
            ]);
            session()->flash('success', 'Question has been updated SuccessFully !');
            return redirect(route('questions.index'));
        }
        abort(403);
    }

    
    public function destroy(Question $question)
    {
        //method 2 for calling gate
        //if(auth()->user()->can('delete-question', $question)){
        if($this->authorize('delete',$question)){
            $question->delete();
            session()->flash('success','Question has been added deleted Successfully!');
            return redirect(route('questions.index'));
        }
        abort(403);
    }    
}


















